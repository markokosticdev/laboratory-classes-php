<?php

spl_autoload_register(function ($class) {
    require_once "../class/class." . $class . ".php";
});

session_start();

if (isset($_SESSION["user"])) {

    $action = $_GET['action'];

    switch ($action) {

        case "term-add":

            $exercise = $_POST["exercise"];
            $assistants = $_POST["assistants"];
            $laboratory = $_POST["laboratory"];
            $datetime = $_POST["datetime"];

            if (Term::add($exercise, User::toObjectArray(User::loadSelected($assistants)), $laboratory, $datetime)) echo 1;
            else echo 0;
            break;

        case "term-edit":

            $termId = $_POST["term"];
            $exercise = $_POST["term-exercise"];
            $assistants = $_POST["assistants"];
            $laboratory = $_POST["laboratory"];
            $datetime = $_POST["datetime"];

            if (Term::update($termId, $exercise, User::toObjectArray(User::loadSelected($assistants)), $laboratory, $datetime)) echo 1;
            else echo 0;
            break;

        case "term-delete":

            $termId = $_POST["term"];

            if (Term::delete($termId)) {

                echo 1;
            } else echo 0;
            break;

        case "term-load-one":

            $term = new Term($_GET["termId"]);

            if ($term->load()) {
                $data = array(
                    "exercise" => $term->exercise,
                    "assistants" => $term->assistants,
                    "laboratory" => $term->laboratory,
                    "datetime" => date("Y-m-d\TH:i:s", strtotime($term->datetime))
                );
                echo json_encode($data);
            } else echo 0;
            break;

        case "term-load-all":

            if ($term = Term::loadAll()) {

                echo json_encode($term);
            } else echo 0;
            break;


        case "term-load-selected":

            if ($term = Term::loadSelected($_GET["exerciseId"], "exercise")) {

                echo json_encode($term);
            } else echo 0;
            break;

        case "term-exercise-load-selected":

            if ($exercise = Exercise::loadSelected($_GET["subjectId"], "subject")) {

                echo json_encode($exercise);
            } else echo 0;

            break;

        case "term-subject-load-all":

            if ($subject = Subject::loadAll()) {

                echo json_encode($subject);
            } else echo 0;
            break;

        case "term-laboratory-load-all":

            if ($laboratory = Laboratory::loadAll()) {

                echo json_encode($laboratory);
            } else echo 0;
            break;

        case "term-assistant-load-all":

            if ($assistant = Assistant::loadAll(2)) {

                echo json_encode($assistant);
            } else echo 0;
            break;
    }
}