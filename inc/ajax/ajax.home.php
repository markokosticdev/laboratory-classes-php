<?php

spl_autoload_register(function ($class) {
    require_once "../class/class." . $class . ".php";
});

session_start();

$action = $_GET['action'];

switch ($action) {

    case "home-start":

        if ($subject = Subject::loadAll()) {

            echo json_encode($subject);
        } else echo 0;


        break;


    case "home-subject":

        if ($subject = Subject::loadSelected($_GET["subjectId"])) {

            echo json_encode($subject);
        } else echo 0;

        break;

    case "home-exercise":

        if ($exercise = Exercise::loadSelected($_GET["exerciseId"])) {

            echo json_encode($exercise);
        } else echo 0;

        break;

    case "home-term":

        if ($term = Term::loadSelected($_GET["termId"])) {

            echo json_encode($term);
        } else echo 0;

        break;

    case "home-material":

        if ($material = Material::loadSelected($_GET["materialId"])) {

            echo json_encode($material);
        } else echo 0;

        break;

    case "home-assistant":

        if ($assistant = User::loadSelected($_GET["assistantId"])) {

            echo json_encode($assistant);
        } else echo 0;

        break;
}