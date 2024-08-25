<?php

namespace controller\admin;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use Ramsey\Uuid\Uuid;

class ManageStudentController
{

    private const BASE_URL = "views/admin/student";
    private const BASE_MODEL = "STUDENT";
    private const ROLES = ["student"];

    private static function getBaseModel()
    {
        return new Model(self::BASE_MODEL);
    }

    // ================================= Renderers ======================================================


    /**
     * Display the screen of the student
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function renderScreen(Request $req, Response $res)
    {
        try {
            $studentModel = self::getBaseModel();
            $student = $studentModel->find();
            $res->status(200)->render(self::BASE_URL . "/screen.view.php", ["student" => $student]);

        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch student: " . $e->getMessage()]);
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

        $res->status(200)->render(self::BASE_URL . "/pages/create.page.php", ["roles" => self::ROLES]);
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

            $studentModel = self::getBaseModel();

            $crendtials = $studentModel->findOne(["ID" => $UID]);

            if (!$crendtials) {
                $res->status(400)->redirect("/student/update?id=" . $UID, ["error" => "Student already exist"]);
            }

            $res->status(200)->render(
                self::BASE_URL . "/pages/update.page.php",
                [
                    "UID" => $UID,
                    "details" => $crendtials,
                    "roles" => self::ROLES
                ]
            );

        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch student: " . $e->getMessage()]);
        }
    }


    // ================================= Actions ======================================================

    /**
     * Create student Handler
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function createStudent(Request $req, Response $res)
    {
        $email = $req->body["EMAIL"] ?? null;
        $password = $req->body["PASSWORD"] ?? null;
        $phone_number = $req->body["PHONE_NUMBER"] ?? null;

        $student_model = self::getBaseModel();


        // Check if the student exist
        if (self::studentExist($email, $phone_number)) {
            $res->status(400)->redirect("/student/create", ["error" => "Student already exist"]);
        }

        // hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
        unset($req->body["PASSWORD"]);

        // generate UUID
        $UID = Uuid::uuid4()->toString();

        // Store the payload
        $result = $student_model->createOne([
            "ID" => $UID,
            ...$req->body,
            "PASSWORD" => $hashed_password,
        ]);

        if (!$result) {
            $res->status(400)->redirect("/student/create", ["error" => "Something went wrong"]);
        }

        $res->status(200)->redirect("/student/create", ["success" => "Student Created successfully"]);

    }

    /**
     * Update student controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function updateStudent(Request $req, Response $res)
    {
        $UID = $req->query["id"];
        $password = $req->body["PASSWORD"];

        unset($req->body["_method"]);


        // check if student exist
        $credentials = (self::getBaseModel())->findOne(["ID" => $UID], ["select" => "ID"]);

        if (!$credentials) {
            $res->status(400)->redirect("/student/update?id=" . $UID, ["error" => "Student doesnt exist"]);
        }

        // De the password if empty else if exist then hash it
        if (!isset($password) || $password === "") {
            unset($req->body["PASSWORD"]);
        } else if (isset($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
            $req->body["PASSWORD"] = $hashed_password;
        }

        // Update Credentials
        $result = (self::getBaseModel())->updateOne(
            [...$req->body],
            ["ID" => $UID]
        );

        if (!$result) {
            $res->status(400)->redirect("/student/update?id=" . $UID, ["error" => "Update failed"]);
        }

        $res->status(200)->redirect("/student/update?id=" . $UID, ["success" => "Update Successful"]);
    }

    /**
     * Delete student controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function deleteStudent(Request $req, Response $res)
    {
        $UID = $req->query["id"];

        // check if student exist
        $credentials = (self::getBaseModel())->findOne(["ID" => $UID], ["select" => "ID"]);
        if (!$credentials) {
            $res->status(400)->redirect("/student", ["error" => "Student doesnt exist"]);
        }

        // delete the student
        $result = (self::getBaseModel())->deleteOne(["ID" => $UID]);
        if (!$result) {
            $res->status(400)->redirect("/students", ["error" => "Something went wrong"]);
        }
        $res->status(200)->redirect("/students", ["success" => "Deleted successfully"]);


    }


    protected static function studentExist($email, $phone_number)
    {
        return self::getBaseModel()->findOne([
            "#or" => ["EMAIL" => $email, "PHONE_NUMBER" => $phone_number]
        ], ["select" => "ID"]);
    }
}