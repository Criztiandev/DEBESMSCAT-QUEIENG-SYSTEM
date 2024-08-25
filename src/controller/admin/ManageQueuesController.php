<?php

namespace controller\admin;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use Ramsey\Uuid\Uuid;

class ManageQueuesController
{
    private const BASE_URL = "views/admin/batch";
    private static $queue_model;

    public static function renderScreen(Request $req, Response $res)
    {
        $queue_id = $req->query["id"];
        $current_index = (int) $req->query["selected"];



        self::$queue_model = new Model("QUEUE_ENTRIES");

        $queue_credentials = self::$queue_model->findOne(["QUEUE_ID" => $queue_id]);

        if (!$queue_credentials) {
            $res->status(400)->redirect("/batch", ["error" => "Batch doesn't exist"]);
        }

        $student_list = json_decode($queue_credentials["STUDENT_QUEUE"], true);

        if ($student_list === null) {
            $student_list = [];
        }

        if (count($student_list) <= $current_index) {
            $res->status(400)->redirect("/batch/queue?id=" . $queue_id . "&selected=" . $current_index = 0, ["error" => "Invalid Selection"]);
        }


        $res->status(200)->render(self::BASE_URL . "/pages/start-session.page.php", ["queue_id" => $queue_id, "student_list" => $student_list, "current_index" => $current_index]);
    }



    public static function nextStudent(Request $req, Response $res)
    {
        $queue_id = $req->query["id"];
        $selected_id = $req->query["selected"];

        $queue_model = new Model("QUEUE_ENTRIES");
        $batch_model = new Model("BATCHES");
        $booking_model = new Model("BOOKING");

        $queue_credentials = $queue_model->findOne(["QUEUE_ID" => $queue_id]);

        if (!$queue_credentials) {
            return $res->status(400)->redirect("/batch", ["error" => "Oops! Something went wrong"]);
        }

        $student_list = json_decode($queue_credentials["STUDENT_QUEUE"]) ?? [];

        // Separate students into different status groups
        $processing = [];
        $waiting = [];
        $hold = [];
        $done = [];

        foreach ($student_list as $student) {
            switch ($student->STATUS) {
                case 'PROCESSING':
                    $processing[] = $student;
                    break;
                case 'HOLD':
                    $hold[] = $student;
                    break;
                case 'WAITING':
                    $waiting[] = $student;
                    break;

                case 'DONE':
                    $done[] = $student;
                    break;
            }
        }

        // Mark the selected student as DONE
        foreach ($student_list as $student) {
            if ($student->STUDENT_ID === $selected_id) {
                $student->STATUS = "DONE";
                $done[] = $student;
                break;
            }
        }

        // Remove the completed student from its original array
        $processing = array_filter($processing, function ($student) use ($selected_id) {
            return $student->STUDENT_ID !== $selected_id;
        });
        $waiting = array_filter($waiting, function ($student) use ($selected_id) {
            return $student->STUDENT_ID !== $selected_id;
        });
        $hold = array_filter($hold, function ($student) use ($selected_id) {
            return $student->STUDENT_ID !== $selected_id;
        });

        // If there's no PROCESSING student, move the next WAITING or HOLD student to PROCESSING
        if (empty($processing)) {
            if (!empty($waiting)) {
                $next_student = array_shift($waiting);
            } elseif (!empty($hold)) {
                $next_student = array_shift($hold);
            } else {
                $next_student = null;
            }

            if ($next_student) {
                $next_student->STATUS = "PROCESSING";
                array_unshift($processing, $next_student);
            }
        }

        // Reorder the list
        $reordered_student_list = array_merge($processing, $hold, $waiting, $done);

        // Update the Queue with the new order
        $updated_queue = $queue_model->updateOne(
            ["STUDENT_QUEUE" => json_encode($reordered_student_list)],
            ["QUEUE_ID" => $queue_id]
        );

        if (!$updated_queue) {
            return $res->status(400)->redirect("/batch/queue?id=" . $queue_id . "&selected=0", ["error" => "Oops! Something went wrong"]);
        }

        // Check if all students are done
        $is_all_done = empty($processing) && empty($waiting) && empty($hold);

        if ($is_all_done) {
            $batch_model->updateOne(["STATUS" => "DONE"], ["BATCH_ID" => $queue_credentials["BATCH_ID"]]);
            $booking_model->updateOne(["STATUS" => "DONE"], ["BATCH_ID" => $queue_credentials["BATCH_ID"]]);

            // Delete the Queue
            $queue_model->deleteOne(["QUEUE_ID" => $queue_id]);

            return $res->status(200)->redirect("/batch", ["success" => "All students have been served. Session is complete."]);
        }

        return $res->status(200)->redirect("/batch/queue?id=" . $queue_id . "&selected=0", ["success" => "Next student"]);
    }

    public static function holdStudent(Request $req, Response $res)
    {
        $queue_id = $req->query["id"];
        $selected_id = $req->query["selected"];

        $queue_model = new Model("QUEUE_ENTRIES");

        $queue_credentials = $queue_model->findOne(["QUEUE_ID" => $queue_id]);

        if (!$queue_credentials) {
            return $res->status(400)->redirect("/batch", ["error" => "Oops! Something went wrong"]);
        }

        $student_list = json_decode($queue_credentials["STUDENT_QUEUE"]) ?? [];

        // Separate students into different status groups
        $processing = [];
        $waiting = [];
        $hold = [];
        $done = [];

        foreach ($student_list as $student) {
            if ($student->STUDENT_ID === $selected_id) {
                $student->STATUS = "HOLD";
                $hold[] = $student;
            } else {
                switch ($student->STATUS) {
                    case 'PROCESSING':
                        $processing[] = $student;
                        break;
                    case 'HOLD':
                        $hold[] = $student;
                        break;
                    case 'WAITING':
                        $waiting[] = $student;
                        break;
                    case 'DONE':
                        $done[] = $student;
                        break;
                }
            }
        }

        // If there was an PROCESSING student and it was put on hold, move the next WAITING to PROCESSING
        if (empty($processing) && !empty($waiting)) {
            $waiting[0]->STATUS = "PROCESSING";
            $processing[] = array_shift($waiting);
        }



        // Reorder the list
        $reordered_student_list = array_merge($processing, $hold, $waiting, $done);

        // Update the Queue with the new order
        $updated_queue = $queue_model->updateOne(
            ["STUDENT_QUEUE" => json_encode($reordered_student_list)],
            ["QUEUE_ID" => $queue_id]
        );

        if (!$updated_queue) {
            $res->status(400)->redirect("/batch/queue?id=" . $queue_id . "&selected=0", ["error" => "Oops! Something went wrong"]);
        }

        $res->status(200)->redirect("/batch/queue?id=" . $queue_id . "&selected=0", ["success" => "Student placed on hold"]);
    }
}