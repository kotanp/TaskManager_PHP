<?php

include_once 'Core/Database.php';
include_once 'Core/Model.php';
include_once 'Model/Task.php';
include_once 'Model/User.php';
include_once 'Core/Route.php';
include_once 'Core/Request.php';
include_once 'web.php';

header('Access-Control-Allow-Origin: *');

use App\Core\Database;
use App\Core\Model;
use App\Core\Route;

$database = new Database('localhost','laravel_tasks','root','','');
$db = $database->connect();

//$task = new Task($db);
Model::$connection=$db;
$routes = new Route();
$routes->resolve();
// $id = isset($_GET['id'])?$_GET['id']:die();

// $single_task = TaskController::show($id);
// $row = $single_task->fetch(PDO::FETCH_ASSOC);
// echo json_encode($row);

