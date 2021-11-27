<?php

namespace Config;

class AppConfig
{
    private $data = [];

    public function __construct($fileName)
    {
        $content = file_get_contents($fileName);
        $this->data = json_decode($content,true);
    }

    public function get($name) {
        return $this->data[$name];
    }

}