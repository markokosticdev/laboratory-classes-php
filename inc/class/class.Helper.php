<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

class Helper extends User
{

    public function __construct($userId = null)
    {

        parent::__construct($userId);
    }

    public function __get($name)
    {

        return isset($this->$name) ? $this->$name : null;
    }

    public function __set($name, $value)
    {

        if (property_exists("Helper", $this->$name))
            $this->$name = $value;
        else return null;
    }

    public function __clone()
    {
    }

}
