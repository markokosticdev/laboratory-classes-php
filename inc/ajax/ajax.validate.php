<?php

spl_autoload_register(function ($class) {
    require_once "../class/class." . $class . ".php";
});

session_start();

if (isset($_SESSION["user"])) {

    $action = $_GET['action'];

    switch ($action) {

        case "validate-username":
            if (User::isExist($_POST["username"])) echo 1;
            else echo 0;
            break;

        case "validate-subject-title":
            if (Subject::isExist($_POST["title"])) echo 1;
            else echo 0;
            break;

        case "validate-exercise-title":
            if (Exercise::isExist($_POST["title"])) echo 1;
            else echo 0;
            break;


    }
}