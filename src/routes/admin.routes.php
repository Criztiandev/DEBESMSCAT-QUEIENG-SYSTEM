<?php
use controller\admin\AdminController;

use controller\admin\ManageBookingController;
use controller\admin\ManageQueuesController;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use lib\Router\Express;

use controller\admin\ManageBatchController;
use controller\admin\ManageOperatorController;
use controller\admin\ManageStudentController;
use controller\admin\ManageDepartmentController;

$router = Express::Router();

$router->get("/", fn(Request $req, Response $res) => AdminController::renderDashboard($req, $res));

/**Booking Routes */
$router->get("/booking", fn(Request $req, Response $res) => ManageBookingController::renderScreen($req, $res));

$router->get("/booking/approve", fn(Request $req, Response $res) => ManageBookingController::approveBooking($req, $res));
$router->put("/booking/reschedule", fn(Request $req, Response $res) => ManageBookingController::rescheduleBooking($req, $res));


/**Department Routes */
$router->get("/department", fn(Request $req, Response $res) => ManageDepartmentController::renderScreen($req, $res));
$router->get("/department/create", fn(Request $req, Response $res) => ManageDepartmentController::renderCreatePage($req, $res));
$router->get("/department/update", fn(Request $req, Response $res) => ManageDepartmentController::renderUpdatePage($req, $res));

$router->post("/department/create", fn(Request $req, Response $res) => ManageDepartmentController::createDepartment($req, $res));
$router->delete("/department/delete", fn(Request $req, Response $res) => ManageDepartmentController::deleteDepartment($req, $res));
$router->put("/department/update", fn(Request $req, Response $res) => ManageDepartmentController::updateDepartment($req, $res));


/**Batch Routes */
$router->get("/batch", fn(Request $req, Response $res) => ManageBatchController::renderScreen($req, $res));
$router->get("/batch/create", fn(Request $req, Response $res) => ManageBatchController::renderCreatePage($req, $res));
$router->get("/batch/update", fn(Request $req, Response $res) => ManageBatchController::renderUpdatePage($req, $res));

// Start the session
$router->get("/batch/session/start", fn(Request $req, Response $res) => ManageBatchController::renderStartSession($req, $res));
$router->get("/batch/queue", fn(Request $req, Response $res) => ManageQueuesController::renderScreen($req, $res));

$router->put("/batch/queue/next", fn(Request $req, Response $res) => ManageQueuesController::nextStudent($req, $res));
$router->put("/batch/queue/hold", fn(Request $req, Response $res) => ManageQueuesController::holdStudent($req, $res));
$router->post("/batch/create", fn(Request $req, Response $res) => ManageBatchController::createBatch($req, $res));
$router->delete("/batch/delete", fn(Request $req, Response $res) => ManageBatchController::deleteBatch($req, $res));
$router->put("/batch/update", fn(Request $req, Response $res) => ManageBatchController::updateBatch($req, $res));


/**Student Routes */
$router->get("/students", fn(Request $req, Response $res) => ManageStudentController::renderScreen($req, $res));
$router->get("/student/create", fn(Request $req, Response $res) => ManageStudentController::renderCreatePage($req, $res));
$router->get("/student/update", fn(Request $req, Response $res) => ManageStudentController::renderUpdatePage($req, $res));


$router->post("/student/create", fn(Request $req, Response $res) => ManageStudentController::createStudent($req, $res));
$router->delete("/student/delete", fn(Request $req, Response $res) => ManageStudentController::deleteStudent($req, $res));
$router->put("/student/update", fn(Request $req, Response $res) => ManageStudentController::updateStudent($req, $res));


// Operator Routes
$router->get("/operator", fn(Request $req, Response $res) => ManageOperatorController::renderScreen($req, $res));
$router->get("/operator/create", fn(Request $req, Response $res) => ManageOperatorController::renderCreatePage($req, $res));
$router->get("/operator/update", fn(Request $req, Response $res) => ManageOperatorController::renderUpdatePage($req, $res));


$router->post("/operator/create", fn(Request $req, Response $res) => ManageOperatorController::createOperator($req, $res));
$router->delete("/operator/delete", fn(Request $req, Response $res) => ManageOperatorController::deleteOperator($req, $res));
$router->put("/operator/update", fn(Request $req, Response $res) => ManageOperatorController::updateOperator($req, $res));