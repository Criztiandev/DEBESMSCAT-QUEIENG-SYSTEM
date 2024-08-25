<?php

namespace controller\student;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use lib\Router\Express;
use Ramsey\Uuid\Uuid;

class StudentController
{

    public static function renderDashboard(Request $req, Response $res)
    {
        //get the booking ID that is related to you
        $booking_model = new Model("BOOKING");
        $user_id = Express::Session()->get("UID");

        $booking_list = $booking_model->find(["STUDENT_ID" => $user_id], ["select" => "ID,BATCH_ID,QUEUE_NUMBER,REQUEST_FORM,PURPOSE,STATUS"]);

        $booking_details = array_map(function ($item) {
            $batch_model = new Model("BATCHES");

            // Fetch batch details
            $batch_details = $batch_model->findOne(
                ["BATCH_ID" => $item["BATCH_ID"]],
                ["select" => "BATCH_NAME,YEARLEVEL,BOOKING_DATE"]
            );

            $request_form = json_decode($item["REQUEST_FORM"], true);
            $request_form_length = is_array($request_form) ? count($request_form) : 0;


            return [
                "BOOKING_ID" => $item["ID"],
                "BATCH_NAME" => $batch_details["BATCH_NAME"],
                "BOOKING_DATE" => $batch_details["BOOKING_DATE"],
                "YEARLEVEL" => $batch_details["YEARLEVEL"],
                "REQUEST_FORM" => $request_form_length,
                "STATUS" => $item["STATUS"],
                "QUEUE_NUMBER" => $item["QUEUE_NUMBER"]
            ];
        }, $booking_list);





        $res->status(200)->render("views/student/dashboard.view.php", ["booking_lists" => $booking_details]);
    }

    public static function renderBooking(Request $req, Response $res)
    {
        $currentID = $_SESSION["UID"];

        $credentials = (new Model("STUDENT"))->find(["ID" => $currentID], ["select" => "YEARLEVEL"]);
        $booking_list = (new Model("BATCHES"))->find(["#or" => ["STATUS" => "Active",]]);

        $updated_booking_list = array_filter($booking_list, function ($item) use ($credentials) {
            return $item["STATUS"] === "Active" &&
                (substr($item["YEARLEVEL"], 0, 1) === substr($credentials["YEARLEVEL"], 0, 1) ||
                    $item["YEARLEVEL"] === "1st");
        });

        $res->status(200)->render("views/student/booking/screen.view.php", ["booking" => $updated_booking_list]);
    }

    public static function renderApplicationForm(Request $req, Response $res)
    {

        $batch_id = $req->query["id"];
        $batch_credentials = (new Model("BATCHES"))->findOne(["BATCH_ID" => $batch_id]);
        $request_form_list = require from("controller/student/data/request_form.data.php");


        $res->status(200)->render("views/student/booking/pages/apply.view.php", ["details" => $batch_credentials, "request_form_list" => $request_form_list]);
    }



    public static function applyApplicationForm(Request $req, Response $res)
    {
        $batch_id = $req->query["id"];
        $user_id = Express::Session()->get("UID");


        // check if the user is existing on the same batch
        $batch_model = new Model("BATCHES");
        $booking_model = new Model("BOOKING");

        $booking_credentials = $booking_model->findOne(["STUDENT_ID" => $user_id], );
        $batch_credentials = $batch_model->findOne(["BATCH_ID" => $batch_id]);

        $batch_id = $batch_credentials["BATCH_ID"];

        if ($booking_credentials["BATCH_ID"] === $batch_credentials["BATCH_ID"]) {
            $res->status(400)->redirect("/booking/apply?id=" . $batch_id, ["error" => "Your application form is " . $booking_credentials["STATUS"]]);
        }


        $student_list = json_decode($batch_credentials["STUDENT_IDS"]);




        // extract the users
        if (!$student_list === null && \in_array($user_id, $student_list)) {
            $res->status(400)->redirect("/booking/apply?id=" . $batch_id, ["error" => "You are already in the batch, Please try again later"]);
        }

        $BKID = Uuid::uuid4()->toString();

        // create the booking
        $result = $booking_model->createOne([
            "ID" => $BKID,
            "STUDENT_ID" => $user_id,
            "BATCH_ID" => $batch_id,
            "REQUEST_FORM" => json_encode($req->body["REQUEST_FIELD"]),
            "PURPOSE" => $req->body["PURPOSE"],
            "STATUS" => "PENDING",
        ]);

        if (!$result) {
            $res->status(400)->redirect("/booking/apply?id=" . $batch_id, ["error" => "Something went wrong, Please try again later"]);
        }

        $res->status(200)->redirect("/booking/apply?id=" . $batch_id, ["success" => "Booked Successfully"]);
    }



    public static function deleteApplication(Request $req, Response $res)
    {
        $BKID = $req->query["id"];
        $booking_model = new Model("BOOKING");

        // check if the booking exist
        $booking_credentials = $booking_model->findOne(["ID" => $BKID]);

        if (!$booking_credentials) {
            $res->status(400)->redirect("/", ["error" => "Booking doest exist, Please try agan later"]);
        }

        if (!$booking_credentials["STATUS"] === "PENDING") {
            $res->status(400)->redirect("/", ["error" => "Im sorry, You cannot perform this action"]);
        }

        // delete the booking
        $result = $booking_model->deleteOne(["ID" => $BKID]);

        if (!$result) {
            $res->status(400)->redirect("/", ["error" => "Something went wrong"]);
        }

        $res->status(200)->redirect("/", ["success" => "Booked Cancel Successfully"]);

    }
}