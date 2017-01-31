<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

class Methods
{

    public static function checkIsSet(...$vars)
    {

        foreach ($vars as $var) {
            if (!isset($var)) return false;
        }
        return true;
    }

    public static function checkIsNull(...$vars)
    {

        foreach ($vars as $var) {
            if (!is_null($var)) return false;
        }
        return true;
    }


    public static function checkIsEmpty(...$vars)
    {

        foreach ($vars as $var) {
            if (!empty($var)) return false;
        }
        return true;
    }

    public static function nextDir($dir)
    {

        $dirInc = 1;
        while (1) {

            $dirName = sha1($dirInc);
            if (!file_exists($dir . $dirName)) {
                mkdir($dir . $dirName, 0777);
                return $dirName;
            } else {
                $dirInc++;
            }
        }
    }

}