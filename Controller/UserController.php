<?php

namespace App\Controller;

use App\Model\User;
use App\Core\Request;

class UserController{

    public static function index(){
        $tasks = User::all();
        return $tasks;
    }

    public static function show($taskId){
        $task = User::find($taskId);
        return $task;
    }


    public static function store(){
        $request = new Request();
        $data = $request->getData();
        $task = new User();
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->end_date = $data['end_date'];
        $task->userId = $data['userId'];
        $task->status = $data['status'];
        User::save($task);
    }

    public static function update($taskId){
        $task = new User();
        $request = new Request();
        $data = $request->getData();
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->end_date = $data['end_date'];
        $task->userId = $data['userId'];
        $task->status = $data['status'];
        User::update($task, $taskId);
    }

    public static function destroy($taskId){
        User::delete($taskId);
    }

}