<?php

spl_autoload_register(function ($class) {
    require_once "../class/class." . $class . ".php";
});

session_start();

if (isset($_SESSION["user"])) {

    $action = $_GET['action'];

    switch ($action) {

        case "exercise-add":

            $subject = $_POST["subject"];
            $title = $_POST["title"];
            $number = $_POST["number"];
            $description = (!empty($_POST["description"])) ? $_POST["description"] : null;
            $materialsNew = (!empty($_POST["materials"])) ? $_POST["materials"] : null;

            if (isset($_POST["dir"])) {
                $dirTmp = "../../upload/tmp/" . $_POST["dir"] . "/";
                $dirMaterial = "../../upload/material/" . Methods::nextDir("../../upload/material/") . "/";

                $materialsTemp = array();
                if ($dir = opendir($dirTmp)) {

                    $i = 0;
                    while (false !== ($entry = readdir($dir))) {

                        if ($entry != "." && $entry != ".." && !is_dir($entry)) {

                            if (rename($dirTmp . $entry, $dirMaterial . $entry)) {

                                $materialsTemp[$i]["title"] = str_replace("." . pathinfo($entry)["extension"], "", $entry);
                                $materialsTemp[$i]["file"] = str_replace("." . pathinfo($entry)["extension"], "", $entry);
                                $materialsTemp[$i]["location"] = $dirMaterial;
                                $materialsTemp[$i]["extension"] = pathinfo($entry)["extension"];
                                $i++;
                            }
                        }
                    }
                    closedir($dir);
                    if ($i == 0) {
                        rmdir($dirTmp);
                        rmdir($dirMaterial);
                    } else {
                        rmdir($dirTmp);
                    }
                }
                $materialsNew = Material::toObjectArray($materialsTemp);
            }

            if (Exercise::add($subject, $title, $number, $description, $materialsNew)) echo 1;
            else echo 0;
            break;

        case "exercise-edit":

            $exerciseId = $_POST["exercise"];
            $subject = $_POST["subject"];
            $title = $_POST["title"];
            $number = $_POST["number"];
            $description = (!empty($_POST["description"])) ? $_POST["description"] : null;
            $materialsNew = (!empty($_POST["materials"])) ? $_POST["materials"] : null;
            $materialsOld = (!empty($_POST["materials-old"])) ? $_POST["materials-old"] : null;
            $materialsOldDb = Material::loadSelected($exerciseId, "exercise");

            if (isset($_POST["dir"]) && !is_null($materialsNew)) {
                $dirTmp = "../../upload/tmp/" . $_POST["dir"] . "/";
                $dirMaterial = $materialsOldDb[0]["location"];
                $dirMaterialNew = 1;


                if ($dirMaterial == false) {
                    $dirMaterial = "../../upload/material/" . Methods::nextDir("../../upload/material/") . "/";
                } else {
                    $dirMaterialNew = 0;
                }

                $materialsTemp = array();
                if ($dir = opendir($dirTmp)) {

                    $i = 0;
                    while (false !== ($entry = readdir($dir))) {

                        if ($entry != "." && $entry != ".." && !is_dir($entry)) {

                            if (rename($dirTmp . $entry, $dirMaterial . $entry)) {

                                $materialsTemp[$i]["title"] = str_replace("." . pathinfo($entry)["extension"], "", $entry);
                                $materialsTemp[$i]["file"] = str_replace("." . pathinfo($entry)["extension"], "", $entry);
                                $materialsTemp[$i]["location"] = $dirMaterial;
                                $materialsTemp[$i]["extension"] = pathinfo($entry)["extension"];
                                $i++;
                            }
                        }
                    }
                    closedir($dir);
                    if ($i == 0) {
                        rmdir($dirTmp);
                        if ($dirMaterialNew == 1) rmdir($dirMaterial);
                    } else {
                        rmdir($dirTmp);
                    }
                }
                $materialsNew = Material::toObjectArray($materialsTemp);
            } else {

                $materialsNew = array();
            }

            $materialsTemp = array();


            if (is_array($materialsOld) && is_array($materialsOldDb)) {

                for ($i = 0; $i < count($materialsOldDb); $i++) {
                    for ($j = 0; $j < count($materialsOldDb); $j++) {
                        if ($materialsOld["materialId"][$i] == $materialsOldDb[$j]["materialId"]) {
                            $materialsOldDb[$j]["title"] = str_replace("." . pathinfo($materialsOld["title"][$i])["extension"], "", $materialsOld["title"][$i]);
                            array_push($materialsTemp, $materialsOldDb[$j]);
                        }
                    }
                }

            } else if (is_array($materialsOldDb)) {
                $materialsTemp = $materialsOldDb;
            }

            $materialsOld = Material::toObjectArray($materialsTemp);

            $materials = array_merge($materialsOld, $materialsNew);

            if (Exercise::update($exerciseId, $subject, $title, $number, $description, $materials)) echo 1;
            else echo 0;
            break;

        case "exercise-delete":

            $exerciseId = $_POST["exercise"];

            if (Exercise::delete($exerciseId)) echo 1;
            else echo 0;
            break;

        case "exercise-load-one":

            $exercise = new Exercise($_GET["exerciseId"]);

            if ($exercise->load()) {
                $data = array(
                    "subject" => Exercise::loadSubject($exercise->exerciseId),
                    "title" => $exercise->title,
                    "number" => $exercise->number,
                    "description" => $exercise->description,
                    "materials" => $exercise->materials
                );
                echo json_encode($data);
            } else echo 0;
            break;

        case "exercise-load-all":

            if ($exercise = Exercise::loadAll()) {

                echo json_encode($exercise);
            } else echo 0;
            break;

        case "exercise-load-selected":

            if ($exercise = Exercise::loadSelected($_GET["subjectId"], "subject")) {

                echo json_encode($exercise);
            } else echo 0;
            break;

        case "exercise-subject-load-all":

            if ($subject = Subject::loadAll()) {

                echo json_encode($subject);
            } else echo 0;
            break;

        case "exercise-material-add":

            $extensions = array('pdf', 'zip', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx');
            $dirTmp = '../../upload/tmp/' . $_POST["dir"] . "/";

            $count = 0;
            if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_FILES['materials'])) {
                foreach ($_FILES['materials']['name'] as $i => $name) {

                    if (!is_uploaded_file($_FILES['materials']['tmp_name'][$i]))
                        continue;

                    // skip large files
                    //if ( $_FILES['materials']['size'][$i] >= $max_size )
                    //    continue;

                    if (!in_array(pathinfo($name, PATHINFO_EXTENSION), $extensions))
                        continue;

                    if (move_uploaded_file($_FILES["materials"]["tmp_name"][$i], $dirTmp . $name))
                        $count++;
                }

                echo json_encode(array('count' => $count));
            }
            break;

        case "exercise-material-load":

            if ($material = Material::loadSelected($_GET["exerciseId"], "exercise")) {

                echo json_encode($material);
            } else echo 0;
            break;

        case "exercise-material-tmp":

            $dirTmp = '../../upload/tmp/';

            echo Methods::nextDir($dirTmp);
            break;
    }
}