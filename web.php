<?php

include_once 'Core/Route.php';
include_once 'Controller/TaskController.php';
include_once 'Controller/UserController.php';

use App\Core\Route;
use App\Controller\TaskController;
use App\Controller\UserController;

Route::get('/',function(){
    return 'View/index.php';
});

Route::get('/user',function(){
    return 'View/user.php';
});

Route::get('/tasks',[TaskController::class, 'index']);
Route::get('/task/{id}',[TaskController::class, 'show']);
Route::post('/task',[TaskController::class, 'store']);
Route::delete('/task/{id}',[TaskController::class, 'destroy']);
Route::put('/task/{id}',[TaskController::class, 'update']);
Route::get('/tasks/expand',[TaskController::class, 'expandUser']);

Route::get('/users',[UserController::class, 'index']);
Route::get('/user/{id}',[UserController::class, 'show']);
Route::post('/user',[UserController::class, 'store']);
Route::delete('/user/{id}',[UserController::class, 'destroy']);
Route::put('/user/{id}',[UserController::class, 'update']);