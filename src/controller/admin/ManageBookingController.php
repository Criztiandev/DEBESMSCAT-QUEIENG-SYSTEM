<?php

namespace controller\admin;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use lib\Router\Express;
use Ramsey\Uuid\Uuid;

class ManageBookingController
{

    private const BASE_URL = "views/admin/booking";
    private const BASE_MODEL = "BOOKING";

    private static function getBaseModel()
    {
        return new Model(self::BASE_MODEL);
    }



    // ================================= Renderers ======================================================


    /**
     * Display the screen of the booking
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function renderScreen(Request $req, Response $res)
    {
        try {

            $booking_model = new Model("BOOKING");
            $batch_model = new Model("BATCHES");

            $batch_list = $batch_model->find(["STATUS" => "ACTIVE"]);
            $booking_list = $booking_model->find([], ["select" => "ID,STUDENT_ID,BATCH_ID,QUEUE_NUMBER,REQUEST_FORM,PURPOSE,STATUS"]);

            // remove all the DONE status
            $filtered_booking_list = array_filter($booking_list, function ($item) {
                return $item["STATUS"] === "PENDING";
            });



            $transformed_booking_list = array_map(function ($item) {
                $student_model = new Model("STUDENT");
                $batch_model = new Model("BATCHES");

                // Fetch batch details
                $batch_details = $batch_model->findOne(
                    ["BATCH_ID" => $item["BATCH_ID"]],
                    ["select" => "BATCH_NAME,YEARLEVEL,BOOKING_DATE"]
                );

                $student_details = $student_model->findOne(
                    ["ID" => $item["STUDENT_ID"]],
                    ["select" => "ID,STUDENT_ID,LAST_NAME,FIRST_NAME"]
                );


                $request_form = json_decode($item["REQUEST_FORM"], true);
                $request_form_length = is_array($request_form) ? count($request_form) : 0;


                return [
                    "BOOKING_ID" => $item["ID"],
                    "NATIVE_STUDENT_ID" => $student_details["ID"],
                    "STUDENT_ID" => $student_details["STUDENT_ID"],
                    "FULL_NAME" => $student_details["FIRST_NAME"] . " " . $student_details["LAST_NAME"],
                    "BATCH_NAME" => $batch_details["BATCH_NAME"],
                    "BOOKING_DATE" => $batch_details["BOOKING_DATE"],
                    "YEARLEVEL" => $batch_details["YEARLEVEL"],
                    "REQUEST_FORM" => $request_form_length,
                    "STATUS" => $item["STATUS"],
                    "QUEUE_NUMBER" => $item["QUEUE_NUMBER"]
                ];
            }, $filtered_booking_list);





            $res->status(200)->render(self::BASE_URL . "/screen.view.php", ["booking_list" => $transformed_booking_list, "batch_list" => $batch_list]);
        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch booking: " . $e->getMessage()]);
        }
    }


    public static function approveBooking(Request $req, Response $res)
    {
        $booking_id = $req->query["id"];
        $student_id = $req->query["SID"];

        $booking_model = new Model("BOOKING");
        $batch_model = new Model("BATCHES");


        $booking_credentials = $booking_model->findOne(["ID" => $booking_id,], ["select" => "BATCH_ID,STUDENT_ID"]);
        if (!$booking_credentials) {
            $res->status(400)->redirect("/booking", ["error" => "Booking doesnt exist"]);
        }

        $batch_credentials = $batch_model->findOne(["BATCH_ID" => $booking_credentials["BATCH_ID"]]);

        if (!$batch_credentials) {
            $res->status(400)->redirect("/booking", ["error" => "Batch doesnt exist"]);
        }


        // check if the batch is full
        $batch_max_capacity = $batch_credentials["MAX_STUDENT"];
        $batch_student_list = json_decode($batch_credentials["STUDENT_IDS"]) ?? [];

        if (count($batch_student_list) >= $batch_max_capacity) {
            $res->status(400)->redirect("/booking", ["error" => "Full Capacity"]);
        }

        // check of the current id is existing on the student_id]
        if (in_array($student_id, $batch_student_list)) {
            $res->status(400)->redirect("/booking", ["error" => "Student is already in the batch"]);
        }

        // insert thee student id to  the student id
        $updated_student_list = array_merge($batch_student_list, [$student_id]);


        $booking_update_result = $booking_model->updateOne(["STATUS" => "ACCEPTED"], ["ID" => $booking_id]);
        $batch_update_result = $batch_model->updateOne(["STUDENT_IDS" => json_encode($updated_student_list)], ["BATCH_ID" => $booking_credentials["BATCH_ID"]]);


        if (!$batch_update_result || !$booking_update_result) {
            $res->status(400)->redirect("/booking", ["error" => "Approval has failed, Please try again later"]);
        }

        $res->status(200)->redirect("/booking", ["success" => "Approved Successfuly"]);
    }



    /**
     * Delete booking controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function rejectBooking(Request $req, Response $res)
    {
        $UID = $req->query["id"];


        // check if booking exist
        $credentials = (self::getBaseModel())->findOne(["BOOKING_ID" => $UID], ["select" => "BOOKING_ID"]);


        if (!$credentials) {
            $res->status(400)->redirect("/booking", ["error" => "Booking doesnt exist"]);
        }

        // delete the booking
        $result = (self::getBaseModel())->deleteOne(["BOOKING_ID" => $UID]);
        if (!$result) {
            $res->status(400)->redirect("/booking", ["error" => "Something went wrong"]);
        }
        $res->status(200)->redirect("/booking", ["success" => "Deleted uccessfully"]);


    }


    public static function rescheduleBooking(Request $req, Response $res)
    {
        $student_id = $req->query["id"];
        $batch_id = $req->body["BATCH_ID"];

        $student_model = new Model("STUDENT");
        $batch_model = new Model("BATCHES");
        $booking_model = new Model("BOOKING");



        // check if the use exist   
        $student_credentials = $student_model->findOne(["ID" => $student_id], ["select" => "ID"]);
        if (!$student_credentials) {
            $res->status(400)->redirect("/booking", ["error" => "Student doest exist"]);
        }

        // check if the target batch exist
        $batch_credentials = $batch_model->findOne(["BATCH_ID" => $batch_id]);
        if (!$batch_credentials) {
            $res->status(400)->redirect("/booking", ["error" => "Batch doest exist"]);
        }

        $student_list = json_decode($batch_credentials["STUDENT_IDS"]);

        if ($student_list === null) {
            $student_list = [];
        }


        if (in_array($student_id, $student_list)) {
            $res->status(400)->redirect("/booking", ["error" => "Student is already in the batch, Please select another"]);
        }


        // Insert the ID inside the student list 
        $updated_student_list = array_unique(array_merge($student_list, [$student_id]));

        // update the batch with the updated list
        $update_batch = $batch_model->updateOne(["STUDENT_IDS" => json_encode($updated_student_list)], ["BATCH_ID" => $batch_id]);

        if (!$update_batch) {
            $res->status(400)->redirect("/booking", ["error" => "Something went wrong, Please try again"]);
        }

        // update the booking to accepted
        $updated_booking = $booking_model->updateOne(["STATUS" => "ACCEPTED"], ["STUDENT_ID" => $student_id]);

        if (!$updated_booking) {
            $res->status(400)->redirect("/booking", ["error" => "Something went wrong, Please try again"]);
        }

        $res->status(200)->redirect("/booking", ["success" => "Student has been Re-Schedule"]);
    }

    /**
     * Helpers
     */





}