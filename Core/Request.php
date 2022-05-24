<?php

namespace App\Core;

class Request{
    protected array $data;

    function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            parse_str(file_get_contents('php://input'),$input);
            $this->data = $input;
        }
        else{
            $this->data = $_POST;
        }
    }

    public function getData(){
        return $this->data;
    }
}