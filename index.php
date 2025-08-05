<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "start.php";
require_once('init.php') ;
use Src\Controller\UserController;
use Src\Controller\DeptController;
use Src\Controller\LoginController;
use Src\Controller\UtilityController;
use Src\Controller\FeedbackController;
use Src\Controller\EmailController;
use Src\Controller\LeaveController;
use Src\Controller\ReportController;

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Origin: http://localhost:3000');
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Origin: https://hooisze0206.github.io');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header("Content-Type: text/html");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode( '/', $uri );


// all of our endpoints start with /person
// everything else results in a 404 Not Found
$userId = null;
$id = null;
$type = null;
$other = null;



if ($uri[2] == 'user') {
    // the user id is, of course, optional and must be a number:
    if (isset($uri[3])) {
        $userId = $uri[3];
    }

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new UserController($dbConnection, $requestMethod, $userId);
    $controller->processRequest();
}
elseif ($uri[2] == 'department') {
    if (isset($uri[3])) {
        $userId = $uri[3];
    }

    $requestMethod = $_SERVER["REQUEST_METHOD"];


    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new DeptController($dbConnection, $requestMethod, $userId);
    $controller->processRequest();
}
elseif ($uri[2] == 'login') {
    if (isset($uri[3])) {
        $type = $uri[3];
    }
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new LoginController($dbConnection, $requestMethod, $type);
    $controller->processRequest();
}
elseif ($uri[2] == 'utility') {
    if (isset($uri[3])) {
        $type = $uri[3];
    }
    if (isset($uri[4])) {
        $other = $uri[4];
    }
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new UtilityController($dbConnection, $requestMethod, $type, $other);
    $controller->processRequest();
}elseif ($uri[2] == 'feedback') {
    if (isset($uri[3])) {
        $type = $uri[3];
    }
    if (isset($uri[4])) {
        $id = $uri[4];
    }

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new FeedbackController($dbConnection, $requestMethod,$type , $id);
    $controller->processRequest();
}elseif ($uri[2] == 'email') {
    if (isset($uri[3])) {
        $id = $uri[3];
    }

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new EmailController($dbConnection, $requestMethod, $id);
    $controller->processRequest();
}elseif ($uri[2] == 'leave') {
    if (isset($uri[3])) {
        $type = $uri[3];
    }
    if (isset($uri[4])) {
        $id = $uri[4];
    }

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new LeaveController($dbConnection, $requestMethod, $type, $id);
    $controller->processRequest();
}elseif ($uri[2] == 'report') {
    if (isset($uri[3])) {
        $type = $uri[3];
    }
    if (isset($uri[4])) {
        $id = $uri[4];
    }

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new ReportController($dbConnection, $requestMethod, $type, $id);
    $controller->processRequest();
}

