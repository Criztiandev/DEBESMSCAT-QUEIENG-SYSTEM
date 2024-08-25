<?php

namespace controller\student;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use lib\Router\Express;



class BatchController
{

    public static function ViewBatchSesion(Request $req, Response $res)
    {
        $booking_id = $req->query["id"];
        $UID = Express::Session()->get("UID");

        $batch_model = new Model("BATCHES");
        $booking_model = new Model("BOOKING");
        $queue_model = new Model("QUEUE_ENTRIES");
        $student_model = new Model("STUDENT");

        $booking_credentials = $booking_model->findOne(["ID" => $booking_id], ["select" => "BATCH_ID"]);
        $batch_id = $booking_credentials["BATCH_ID"];


        if (!$booking_credentials) {
            $res->status(400)->redirect("/", ["error" => "Booking doest exist"]);
        }

        $batch_credentials = $batch_model->findOne(["BATCH_ID" => $batch_id], ["select" => "STATUS"]);

        if (!$batch_credentials) {
            $res->status(400)->redirect("/", ["error" => "Batch doest exist"]);
        }

        $batch_status = $batch_credentials["STATUS"];


        if ($batch_status === "DONE") {
            $res->status(400)->redirect("/", ["error" => "Booking is already resolved"]);
        } elseif ($batch_status !== "STARTED") {
            $res->status(400)->redirect("/", ["error" => "Batch is not started yet"]);
        }

        // get the queue
        $queue_credentials = $queue_model->findOne(["BATCH_ID" => $batch_id]);

        $student_list = json_decode($queue_credentials["STUDENT_QUEUE"]) ?? [];

        if (count($student_list) <= 0) {
            $res->status(400)->redirect("/", ["success" => "Batch Session done, Thank you for your patience"]);
        }

        $student_credentials = $student_model->findOne(["ID" => $UID], ["select" => "STUDENT_ID"]);

        if (!$student_credentials) {
            $res->status(400)->redirect("/", ["error" => "Something went wrong"]);
        }


        $res->status(200)->render("views/student/batch/batch-queues.view.php", [
            "student_list" => $student_list,
            "current_id" => $student_credentials["STUDENT_ID"]
        ]);

    }
}