<?php

namespace controller\admin;

use lib\Mangoose\Model;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use Ramsey\Uuid\Uuid;

class ManageDepartmentController
{

    private const BASE_URL = "views/admin/department";
    private const BASE_MODEL = "DEPARTMENT";

    private static function getBaseModel()
    {
        return new Model(self::BASE_MODEL);
    }



    // ================================= Renderers ======================================================


    /**
     * Display the screen of the department
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function renderScreen(Request $req, Response $res)
    {
        try {
            $departmentModel = self::getBaseModel();
            $operatorModel = new Model("OPERATOR");
            $departments = $departmentModel->find();



            $departmentsWithOperators = array_filter(array_map(function ($department) use ($operatorModel) {
                $operator = $operatorModel->findOne(
                    ["ID" => $department['OPERATOR_ID']],
                    ["ID", "FIRST_NAME", "LAST_NAME", "ROLE"]
                );


                if ($operator && $operator['ROLE'] !== 'admin') {
                    $department['OPERATOR_FULL_NAME'] = trim($operator['FIRST_NAME'] . ' ' . $operator['LAST_NAME']);
                    $department['OPERATOR_ROLE'] = $operator['ROLE'];
                    return $department;
                }

                return null;
            }, $departments));




            $res->status(200)->render(self::BASE_URL . "/screen.view.php", ["department" => $departmentsWithOperators]);

        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch department: " . $e->getMessage()]);
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
        $operator_model = new Model("OPERATOR");
        $operator_list = $operator_model->find([], ["ID,FIRST_NAME,LAST_NMAE"]);

        $transformed_staff_list = array_reduce($operator_list, function ($carry, $item) {
            if ($item["ROLE"] !== "admin") {
                $carry[] = [
                    "OPERATOR_ID" => $item["ID"],
                    "OPERATOR_FULLNAME" => trim($item["FIRST_NAME"] . ' ' . $item["LAST_NAME"])
                ];
            }
            return $carry;
        }, []);


        $res->status(200)->render(self::BASE_URL . "/pages/create.page.php", ["operators" => $transformed_staff_list]);
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

            $departmentModel = self::getBaseModel();

            $crendtials = $departmentModel->findOne(["DEPARTMENT_ID" => $UID]);

            if (!$crendtials) {
                $res->status(400)->redirect("/department/update?id=" . $UID, ["error" => "Department already exist"]);
            }

            $res->status(200)->render(
                self::BASE_URL . "/pages/update.page.php",
                [
                    "UID" => $UID,
                    "details" => $crendtials,
                ]
            );

        } catch (\Exception $e) {
            $res->status(500)->json(["error" => "Failed to fetch department: " . $e->getMessage()]);
        }
    }


    // ================================= Actions ======================================================

    /**
     * Create department Handler
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function createDepartment(Request $req, Response $res)
    {


        $department_name = $req->body["DEPARTMENT_NAME"] ?? null;
        $operator = $req->body["OPERATOR_ID"] ?? null;
        $department_model = self::getBaseModel();
        $department_credentials = $department_model->findOne(["#or" => ["DEPARTMENT_NAME" => $department_name, "OPERATOR_ID" => $operator]], ["select" => "DEPARTMENT_ID,WINDOWS_NUMBER"]);



        if ($department_credentials) {
            $res->status(400)->redirect("/department/create", ["error" => "Department Created Failed Provided Name and Operator is already existing"]);
        }

        // generate UUID
        $UID = Uuid::uuid4()->toString();

        // Store the payload
        $result = $department_model->createOne([
            "DEPARTMENT_ID" => $UID,
            ...$req->body,
        ]);

        if (!$result) {
            $res->status(400)->redirect("/department/create", ["error" => "Something went wrong"]);
        }

        $res->status(200)->redirect("/department/create", ["success" => "Department Created successfully"]);

    }

    /**
     * Update department controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function updateDepartment(Request $req, Response $res)
    {
        $UID = $req->query["id"];

        unset($req->body["_method"]);

        // check if department exist
        $credentials = (self::getBaseModel())->findOne(["DEPARTMENT_ID" => $UID], ["select" => "DEPARTMENT_ID"]);

        if (!$credentials) {
            $res->status(400)->redirect("/department/update?id=" . $UID, ["error" => "Department doesnt exist"]);
        }

        // Update Credentials
        $result = (self::getBaseModel())->updateOne(
            [...$req->body],
            ["DEPARTMENT_ID" => $UID]
        );

        if (!$result) {
            $res->status(400)->redirect("/department/update?id=" . $UID, ["error" => "Update failed"]);
        }

        $res->status(200)->redirect("/department/update?id=" . $UID, ["success" => "Update Successfull"]);
    }

    /**
     * Delete department controller
     * @param \lib\Router\classes\Request $req
     * @param \lib\Router\classes\Response $res
     * @return void
     */
    public static function deleteDepartment(Request $req, Response $res)
    {
        $UID = $req->query["id"];


        // check if department exist
        $credentials = (self::getBaseModel())->findOne(["DEPARTMENT_ID" => $UID], ["select" => "DEPARTMENT_ID"]);


        if (!$credentials) {
            $res->status(400)->redirect("/department", ["error" => "Department doesnt exist"]);
        }

        // delete the department
        $result = (self::getBaseModel())->deleteOne(["DEPARTMENT_ID" => $UID]);
        if (!$result) {
            $res->status(400)->redirect("/department", ["error" => "Something went wrong"]);
        }
        $res->status(200)->redirect("/department", ["success" => "Deleted uccessfully"]);


    }


    protected static function departmentExist($email, $phone_number)
    {
        return self::getBaseModel()->findOne([
            "#or" => ["EMAIL" => $email, "PHONE_NUMBER" => $phone_number]
        ], ["select" => "ID"]);
    }
}