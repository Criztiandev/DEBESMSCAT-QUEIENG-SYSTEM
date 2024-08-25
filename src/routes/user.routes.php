<?php
use controller\student\BatchController;
use controller\student\StudentController;
use lib\Router\classes\Request;
use lib\Router\classes\Response;
use lib\Router\Express;


$router = Express::Router();


$router->get("/", fn(Request $req, Response $res) => StudentController::renderDashboard($req, $res));



$router->get("/booking", fn(Request $req, Response $res) => StudentController::renderBooking($req, $res));
$router->get("/booking/apply", fn(Request $req, Response $res) => StudentController::renderApplicationForm($req, $res));


$router->get("/batch/view", fn(Request $req, Response $res) => BatchController::ViewBatchSesion($req, $res));

$router->post("/booking/apply", fn(Request $req, Response $res) => StudentController::applyApplicationForm($req, $res));
$router->delete("/booking/apply/delete", fn(Request $req, Response $res) => StudentController::deleteApplication($req, $res));