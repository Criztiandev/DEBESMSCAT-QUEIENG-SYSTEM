<?php

namespace controller\admin;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use Ramsey\Uuid\Uuid;

class ManageBatchController
{

    private const BASE_URL = "views/admin/batch";
    private const BASE_MODEL = "BATCHES";

    private static function getBaseModel()
    {
        return new Model(self::BASE_MODEL);
    }



    // ================================= Renderers ======================================================


    /**
     * Display the screen of the batch
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function renderScreen(Request $req, Response $res)
    {
        try {
            $batchModel = self::getBaseModel();
            $batch = $batchModel->find();
            $res->status(200)->render(self::BASE_URL . "/screen.view.php", ["batch" => $batch]);

        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch batch: " . $e->getMessage()]);
        }
    }


    /**
     * Display the create page
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function renderCreatePage(Request $req, Response $res)
    {
        $department_model = new Model("DEPARTMENT");
        $department_list = $department_model->find();

        $res->status(200)->render(self::BASE_URL . "/pages/create.page.php", ["departments" => $department_list]);
    }


    public static function renderStartSession(Request $req, Response $res)
    {

        $batch_id = $req->query["id"];
        $batch_model = new Model("BATCHES");
        $queue_model = new Model("QUEUE_ENTRIES");


        $batch_credentials = $batch_model->findOne(["BATCH_ID" => $batch_id]);

        // check if bach exist and it is activated
        if (!$batch_credentials) {
            $res->status(400)->redirect("/batch", ["error" => "Batch doest exist"]);
        }

        if ($batch_credentials && $batch_credentials["STATUS"] === "STARTED") {
            $QID = $batch_credentials["QUEUE_ID"];
            $selected = 0;
            $res->status(200)->redirect("/batch/queue?id=" . $QID . "&selected=" . (int) $selected, ["success" => "Queue Resumed"]);
        }

        // Extact the student list
        $student_list = json_decode($batch_credentials["STUDENT_IDS"]);

        if ($student_list === null || count($student_list) === 0) {
            $res->status(400)->redirect("/batch", ["error" => "Thre is no Students in this batch, Please assign to start"]);
        }


        $queue_count = 0;

        $student_queue_stack = array_map(function ($student_id) use ($queue_count) {
            $student_model = new Model("STUDENT");
            $booking_model = new Model("BOOKING");

            $student_credentials = $student_model->findOne(["ID" => $student_id]);
            $booking_credentials = $booking_model->findOne(["STUDENT_ID" => $student_id], ["select" => "REQUEST_FORM,PURPOSE"]);

            return [
                "STUDENT_ID" => $student_credentials["STUDENT_ID"],
                "FULL_NAME" => $student_credentials["FIRST_NAME"] . " " . $student_credentials["LAST_NAME"],
                "COURSE" => $student_credentials["COURSE"],
                "YEARLEVEL" => $student_credentials["YEARLEVEL"],
                "BOOKING_DETAILS" => $booking_credentials,
                "QUEUE_NUMBER" => $queue_count++,
                "STATUS" => "WAITING"
            ];


        }, $student_list);


        $QID = Uuid::uuid4()->toString();
        $created_queue = $queue_model->createOne([
            "QUEUE_ID" => $QID,
            "BATCH_ID" => $batch_id,
            "STUDENT_QUEUE" => json_encode($student_queue_stack),
            "STATUS" => "ACTIVE"
        ]);

        // Update the Status of the Batch
        $update_batch = $batch_model->updateOne(["STATUS" => "STARTED", "QUEUE_ID" => $QID], ["BATCH_ID" => $batch_id]);


        if (!$created_queue || !$update_batch) {
            $res->status(400)->redirect("/batch", ["error" => "Starting went wrong, Please try again"]);
        }

        $res->status(200)->redirect("/batch/queue?id=" . $QID . "&selected=" . $queue_count, ["success" => "Queue Start"]);
    }


    /**
     * Display the Update Page
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function renderUpdatePage(Request $req, Response $res)
    {
        try {
            $UID = $req->query["id"];

            $batchModel = self::getBaseModel();

            $crendtials = $batchModel->findOne(["BATCH_ID" => $UID]);

            if (!$crendtials) {
                $res->status(400)->redirect("/batch/update?id=" . $UID, ["error" => "Batch already exist"]);
            }

            $res->status(200)->render(
                self::BASE_URL . "/pages/update.page.php",
                [
                    "UID" => $UID,
                    "details" => $crendtials,
                ]
            );

        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch batch: " . $e->getMessage()]);
        }
    }


    // ================================= Actions ======================================================

    /**
     * Create batch Handler
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function createBatch(Request $req, Response $res)
    {

        $batch_name = $req->body["BATCH_NAME"] ?? null;

        $batch_model = self::getBaseModel();


        $batch_credentials = $batch_model->findOne(["BATCH_NAME" => $batch_name], ["select" => "BATCH_ID"]);
        // Check if the batch 
        if ($batch_credentials) {
            $res->status(400)->redirect("/batch/create", ["error" => "Batch already exist"]);
        }

        // generate UUID
        $UID = Uuid::uuid4()->toString();

        // Store the payload
        $result = $batch_model->createOne([
            "BATCH_ID" => $UID,
            ...$req->body,
            "STATUS" => "Active"
        ]);

        if (!$result) {
            $res->status(400)->redirect("/batch/create", ["error" => "Something went wrong"]);
        }

        $res->status(200)->redirect("/batch/create", ["success" => "Batch Created uccessfully"]);

    }

    /**
     * Update batch controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function updateBatch(Request $req, Response $res)
    {
        $UID = $req->query["id"];

        unset($req->body["_method"]);

        // check if batch exist
        $credentials = (self::getBaseModel())->findOne(["BATCH_ID" => $UID], ["select" => "BATCH_ID"]);

        if (!$credentials) {
            $res->status(400)->redirect("/batch/update?id=" . $UID, ["error" => "Batch doesnt exist"]);
        }

        // Update Credentials
        $result = (self::getBaseModel())->updateOne(
            [...$req->body],
            ["BATCH_ID" => $UID]
        );

        if (!$result) {
            $res->status(400)->redirect("/batch/update?id=" . $UID, ["error" => "Update failed"]);
        }

        $res->status(200)->redirect("/batch/update?id=" . $UID, ["success" => "Update Successfull"]);
    }

    /**
     * Delete batch controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function deleteBatch(Request $req, Response $res)
    {
        $UID = $req->query["id"];

        // check if batch exist
        $credentials = (self::getBaseModel())->findOne(["BATCH_ID" => $UID], ["select" => "BATCH_ID"]);


        if (!$credentials) {
            $res->status(400)->redirect("/batch", ["error" => "Batch doesnt exist"]);
        }

        // delete the batch
        $result = (self::getBaseModel())->deleteOne(["BATCH_ID" => $UID]);


        if (!$result) {
            $res->status(400)->redirect("/batch", ["error" => "Something went wrong"]);
        }
        $res->status(200)->redirect("/batch", ["success" => "Deleted uccessfully"]);


    }


    protected static function batchExist($email, $phone_number)
    {
        return self::getBaseModel()->findOne([
            "#or" => ["EMAIL" => $email, "PHONE_NUMBER" => $phone_number]
        ], ["select" => "ID"]);
    }
}