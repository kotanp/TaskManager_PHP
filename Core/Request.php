<?php

namespace App\Core;

class Request{
    protected array $data;

    function __construct()
    {
        $this->data = $_POST;
    }

    public function getData(){
        return $this->data;
    }
}