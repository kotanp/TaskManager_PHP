<?php

include_once 'Core/Route.php';
include_once 'Controller/TaskController.php';

use App\Core\Route;
use App\Controller\TaskController;

Route::get('/',function(){
    return 'View/index.php';
});

//Route::get('/tasks',TaskController::index());