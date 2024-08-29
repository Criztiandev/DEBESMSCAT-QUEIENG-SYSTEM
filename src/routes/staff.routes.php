<?php
use controller\admin\ManageBatchController;
use controller\admin\ManageQueuesController;
use controller\general\AccountController;
use controller\staff\StaffBatchController;
use controller\staff\StaffBookingController;
use controller\staff\StaffController;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use lib\Router\Express;


$router = Express::Router();

$router->get("/", fn(Request $req, Response $res) => StaffController::renderBookings($req, $res));
$router->get("/booking", fn(Request $req, Response $res) => StaffBookingController::renderScreen($req, $res));

$router->get("/booking/approve", fn(Request $req, Response $res) => StaffBookingController::approveBooking($req, $res));
$router->put("/booking/reschedule", fn(Request $req, Response $res) => StaffBookingController::rescheduleBooking($req, $res));

// Batch Screen
/**Batch Routes */
$router->get("/batch", fn(Request $req, Response $res) => StaffBatchController::renderScreen($req, $res));
$router->get("/batch/create", fn(Request $req, Response $res) => StaffBatchController::renderCreatePage($req, $res));
$router->get("/batch/update", fn(Request $req, Response $res) => StaffBatchController::renderUpdatePage($req, $res));

// Start the session
$router->get("/batch/session/start", fn(Request $req, Response $res) => StaffBatchController::renderStartSession($req, $res));
$router->get("/batch/queue", fn(Request $req, Response $res) => ManageQueuesController::renderScreen($req, $res));

$router->put("/batch/queue/next", fn(Request $req, Response $res) => ManageQueuesController::nextStudent($req, $res));
$router->put("/batch/queue/hold", fn(Request $req, Response $res) => ManageQueuesController::holdStudent($req, $res));
$router->post("/batch/create", fn(Request $req, Response $res) => StaffBatchController::createBatch($req, $res));
$router->delete("/batch/delete", fn(Request $req, Response $res) => StaffBatchController::deleteBatch($req, $res));
$router->put("/batch/update", fn(Request $req, Response $res) => StaffBatchController::updateBatch($req, $res));