<?php

namespace controller\admin;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use Ramsey\Uuid\Uuid;

class ManageOperatorController
{

    private const BASE_URL = "views/admin/operator";
    private const BASE_MODEL = "operator";
    private const ROLES = ["admin", "staff"];

    private static function getBaseModel()
    {
        return new Model(self::BASE_MODEL);
    }



    // ================================= Renderers ======================================================


    /**
     * Display the screen of the operator
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function renderScreen(Request $req, Response $res)
    {
        try {
            $operatorModel = self::getBaseModel();
            $operator = $operatorModel->find();
            $res->status(200)->render(self::BASE_URL . "/screen.view.php", ["operator" => $operator]);

        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch operator: " . $e->getMessage()]);
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

        $department_list = (new Model("DEPARTMENT"))->find([]);

        $res->status(200)->render(self::BASE_URL . "/pages/create.page.php", ["department_list" => $department_list, "roles" => self::ROLES]);
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

            $operatorModel = self::getBaseModel();

            $crendtials = $operatorModel->findOne(["ID" => $UID]);

            if (!$crendtials) {
                $res->status(400)->redirect("/operator/update?id=" . $UID, ["error" => "Operator already exist"]);
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
            $res->status(500)->json(["error" => "Failed to fetch operator: " . $e->getMessage()]);
        }
    }


    // ================================= Actions ======================================================

    /**
     * Create operator Handler
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function createOperator(Request $req, Response $res)
    {
        $email = $req->body["EMAIL"] ?? null;
        $password = $req->body["PASSWORD"] ?? null;
        $phone_number = $req->body["PHONE_NUMBER"] ?? null;


        $operator_model = self::getBaseModel();

        // Check if the operator exist
        if (self::operatorExist($email, $phone_number)) {
            $res->status(400)->redirect("/operator/create", ["error" => "Operator already exist"]);
        }

        // hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
        unset($req->body["PASSWORD"]);

        // generate UUID
        $UID = Uuid::uuid4()->toString();

        // Store the payload
        $result = $operator_model->createOne([
            "ID" => $UID,
            ...$req->body,
            "PASSWORD" => $hashed_password,
        ]);

        if (!$result) {
            $res->status(400)->redirect("/operator/create", ["error" => "Something went wrong"]);
        }

        $res->status(200)->redirect("/operator/create", ["success" => "Operator Created uccessfully"]);

    }

    /**
     * Update operator controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function updateOperator(Request $req, Response $res)
    {
        $UID = $req->query["id"];
        $password = $req->body["PASSWORD"];

        unset($req->body["_method"]);

        // check if operator exist
        $credentials = (self::getBaseModel())->findOne(["ID" => $UID], ["select" => "ID"]);

        if (!$credentials) {
            $res->status(400)->redirect("/operator/update?id=" . $UID, ["error" => "Operator doesnt exist"]);
        }

        // Deattach the password if empty else if exist then hash it
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
            $res->status(400)->redirect("/operator/update?id=" . $UID, ["error" => "Update failed"]);
        }

        $res->status(200)->redirect("/operator/update?id=" . $UID, ["success" => "Update Successfull"]);
    }

    /**
     * Delete operator controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function deleteOperator(Request $req, Response $res)
    {
        $UID = $req->query["id"];

        // check if operator exist
        $credentials = (self::getBaseModel())->findOne(["ID" => $UID], ["select" => "ID"]);
        if (!$credentials) {
            $res->status(400)->redirect("/operator", ["error" => "Operator doesnt exist"]);
        }

        // delete the operator
        $result = (self::getBaseModel())->deleteOne(["ID" => $UID]);
        if (!$result) {
            $res->status(400)->redirect("/operator", ["error" => "Something went wrong"]);
        }
        $res->status(200)->redirect("/operator", ["success" => "Deleted uccessfully"]);


    }


    protected static function operatorExist($email, $phone_number)
    {
        return self::getBaseModel()->findOne([
            "#or" => ["EMAIL" => $email, "PHONE_NUMBER" => $phone_number]
        ], ["select" => "ID"]);
    }
}