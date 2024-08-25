<?php

namespace controller\staff;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;

class StaffController
{

    private const BASE_URL = "views/admin/booking";
    private const BASE_MODEL = "BOOKING";

    private static function getBaseModel()
    {
        return new Model(self::BASE_MODEL);
    }

    public static function renderBookings(Request $req, Response $res)
    {
        try {

            $booking_model = new Model("BOOKING");
            $batch_model = new Model("BATCHES");

            $batch_list = $batch_model->find(["STATUS" => "ACTIVE"]);
            $booking_list = $booking_model->find([], ["select" => "ID,STUDENT_ID,BATCH_ID,QUEUE_NUMBER,REQUEST_FORM,PURPOSE,STATUS"]);



            $booking_details = array_map(function ($item) {
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
            }, $booking_list);
            $res->status(200)->render(self::BASE_URL . "/screen.view.php", ["booking_list" => $booking_details, "batch_list" => $batch_list]);
        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch booking: " . $e->getMessage()]);
        }
    }

    public static function renderBatch(Request $req, Response $res)
    {
        try {
            $batchModel = self::getBaseModel();
            $batch = $batchModel->find();
            $res->status(200)->render(self::BASE_URL . "/screen.view.php", ["batch" => $batch]);

        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch batch: " . $e->getMessage()]);
        }
    }

}