<?php

namespace controller\auth;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use lib\Router\Express;
use Ramsey\Uuid\Uuid;

class AuthController
{

    /**
     * Display the login screen
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function loginScreen(Request $req, Response $res)
    {
        $res->status(200)->render("views/auth/login.view.php", );
    }


    public static function loginOperatorScreen(Request $req, Response $res)
    {
        $res->status(200)->render("views/auth/login.operator.view.php", );
    }



    /**
     * Display the registration screen
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function registerScreen(Request $req, Response $res)
    {
        $res->status(200)->render("views/auth/register.view.php");
    }


    /**
     * Authentication of user
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function authenticateUser(Request $req, Response $res)
    {
        $email = $req->body["EMAIL"];
        $password = $req->body["PASSWORD"];

        $student_model = new Model("STUDENT");
        $student_credentials = $student_model->findOne(["#or" => ["EMAIL" => $email, "STUDENT_ID" => $email]]);

        if (!$student_credentials) {
            $res->status(400)->redirect("/", ["error" => "User doesnt exist"]);
        }

        if (!$student_credentials && !password_verify($password, $student_credentials["PASSWORD"])) {
            $res->status(400)->redirect("/", ["error" => "Password is in correct"]);
        }

        // create session
        Express::Session()->insert("UID", $student_credentials["ID"]);
        Express::Session()->insert("credentials", [
            "fullName" => $student_credentials["FIRST_NAME"] . " " . $student_credentials["LAST_NAME"],
            "email" => $student_credentials["EMAIL"],
            "role" => "student",
        ]);
        session_regenerate_id(true);
        $res->status(200)->redirect("/", ["success" => "Login successfully"]);

    }

    /**
     * Authentication of user
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function authenticateOperator(Request $req, Response $res)
    {
        $email = $req->body["EMAIL"];
        $password = $req->body["PASSWORD"];

        $operator_model = new Model("OPERATOR");
        $operator_credentials = $operator_model->findOne(["#or" => ["EMAIL" => $email, "OPERATOR_ID" => $email]]);



        if (!$operator_credentials) {
            $res->status(400)->redirect("/", ["error" => "Operator doesnt exist"]);
        }

        if (!$operator_credentials && !password_verify($password, $operator_credentials["PASSWORD"])) {
            $res->status(400)->redirect("/", ["error" => "Password is in correct"]);
        }


        // create session
        Express::Session()->insert("UID", $operator_credentials["ID"]);
        Express::Session()->insert("credentials", [
            "fullName" => $operator_credentials["FIRST_NAME"] . " " . $operator_credentials["LAST_NAME"],
            "email" => $operator_credentials["EMAIL"],
            "role" => $operator_credentials["ROLE"],
        ]);
        session_regenerate_id(true);

        $res->status(200)->redirect("/", ["success" => "Login successfully"]);

    }


    /**
     * Registration of the user
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function registerUser(Request $req, Response $res)
    {
        $student_id = $req->body["STUDENT_ID"];
        $email = $req->body["EMAIL"];
        $password = $req->body["PASSWORD"];
        $phone_number = $req->body["PHONE_NUMBER"];


        // check if user exist
        $student_model = new Model("STUDENT");

        $student_id = $student_model->findOne(["STUDENT_ID" => $student_id], ["select" => "ID"]);
        if ($student_id) {
            $res->status(400)->redirect("/register", ["error" => "Student Id is already activated"]);
        }

        $student_credentials = $student_model->findOne(["#or" => ["EMAIL" => $email, "PHONE_NUMBER" => $phone_number]], ["select" => "ID"]);
        if ($student_credentials) {
            $res->status(400)->redirect("/register", ["error" => "User already exist"]);
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
        unset($req->body["PASSWORD"]);

        $UID = Uuid::uuid4()->toString();
        $result = $student_model->createOne([
            "ID" => $UID,
            ...$req->body,
            "PASSWORD" => $hashed_password,
        ]);

        if (!$result) {
            $res->status(400)->redirect("/register", ["error" => "User already exist"]);
        }

        $res->status(200)->redirect("/", ["success" => "Registered successfully"]);


    }









}