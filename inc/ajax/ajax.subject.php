<?php

spl_autoload_register(function ($class) {
    require_once "../class/class." . $class . ".php";
});

session_start();

if (isset($_SESSION["user"])) {

    $action = $_GET['action'];

    switch ($action) {

        case "subject-add":

            $title = $_POST["title"];
            $departments = $_POST["departments"];
            $assistants = $_POST["assistants"];
            $description = (!empty($_POST["description"])) ? $_POST["description"] : null;

            if (Subject::add($title, Department::toObjectArray(Department::loadSelected($departments)), User::toObjectArray(User::loadSelected($assistants)), $description)) echo 1;
            else echo 0;
            break;

        case "subject-edit":

            $subjectId = $_POST["subject"];
            $title = $_POST["title"];
            $departments = $_POST["departments"];
            $assistants = $_POST["assistants"];
            $description = (!empty($_POST["description"])) ? $_POST["description"] : null;

            if (Subject::update($subjectId, $title, Department::toObjectArray(Department::loadSelected($departments)), User::toObjectArray(User::loadSelected($assistants)), $description)) echo 1;
            else echo 0;
            break;

        case "subject-delete":

            $subjectId = $_POST["subject"];

            if (Subject::delete($subjectId)) {

                echo 1;
            } else echo 0;
            break;

        case "subject-load-one":

            $subject = new Subject($_GET["subjectId"]);

            if ($subject->load()) {
                $data = array(
                    "title" => $subject->title,
                    "description" => $subject->description,
                    "departments" => $subject->departments,
                    "assistants" => $subject->assistants
                );
                echo json_encode($data);
            } else echo 0;
            break;

        case "subject-load-all":

            if ($subject = Subject::loadAll()) {

                echo json_encode($subject);
            } else echo 0;
            break;

        case "subject-department-load-all":

            if ($department = Department::loadAll()) {

                echo json_encode($department);
            } else echo 0;
            break;

        case "subject-assistant-load-all":

            if ($assistant = Assistant::loadAll(2)) {

                echo json_encode($assistant);
            } else echo 0;
            break;
    }
}