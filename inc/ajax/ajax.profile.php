<?php

spl_autoload_register(function ($class) {
    require_once "../class/class." . $class . ".php";
});

session_start();

if (isset($_SESSION["user"])) {

    $action = $_GET['action'];

    switch ($action) {

        case "profile-edit":

            $user = unserialize($_SESSION["user"]);

            $username = $_POST["username"];
            $password1 = sha1($_POST["password1"]);
            $password2 = sha1($_POST["password2"]);
            $email = $_POST["email"];
            $status = $_POST["status"];
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $description = (!empty($_POST["description"])) ? $_POST["description"] : null;
            $picture = (!empty($_POST["picture"])) ? $_POST["picture"] : null;


            if (!empty($_POST["dir"])) {
                $dirTmp = "../../upload/tmp/" . $_POST["dir"] . "/";

                if (!is_null($user->picture)) {

                    $dirUserPicture = pathinfo($user->picture)['dirname'] . "/";
                    unlink($user->picture);
                } else {

                    $dirUserPicture = "../../upload/user/picture/" . Methods::nextDir("../../upload/user/picture/") . "/";
                }

                if ($dir = opendir($dirTmp)) {

                    $i = 0;
                    while (false !== ($entry = readdir($dir))) {

                        if ($entry != "." && $entry != ".." && !is_dir($entry)) {

                            if (rename($dirTmp . $entry, $dirUserPicture . $entry)) {
                                $picture = $dirUserPicture . $entry;
                                $i++;
                            }
                        }
                    }
                    closedir($dir);
                    if ($i == 0) {
                        rmdir($dirTmp);
                        rmdir($dirUserPicture);
                    } else {
                        rmdir($dirTmp);
                    }
                }
            }

            if (User::update($user->userId, $username, $password1, $user->type, $user->status, $user->fname, $user->lname, $user->email, $picture, $description)) {
                $user->load($user->userId);
                $_SESSION["user"] = serialize($user);
                echo 1;
            } else echo 0;
            break;

        case "profile-load":

            $user = unserialize($_SESSION["user"]);

            if ($user->load($user->userId)) {
                $data = array("username" => $user->username,
                    "email" => $user->email,
                    "status" => $user->status,
                    "fname" => $user->fname,
                    "lname" => $user->lname,
                    "description" => $user->description,
                    "picture" => $user->picture
                );
                echo json_encode($data);
            } else echo 0;
            break;

        case "profile-picture-add":

            $extensions = array('png', 'jpeg', 'jpg', 'jif', 'jfif', 'gif', 'pdf');
            $dirTmp = "../../upload/tmp/" . $_POST["dir"] . "/";

            if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_FILES['picture'])) {

                if (!is_uploaded_file($_FILES['picture']['tmp_name']))
                    continue;
                else if (!in_array(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION), $extensions))
                    continue;

                else if (move_uploaded_file($_FILES["picture"]["tmp_name"], $dirTmp . $_FILES['picture']['name'])) echo 0;
                else echo 0;
            } else echo 0;
            break;

        case "profile-picture-edit":


            break;

        case "profile-picture-delete":


            break;

        case "profile-picture-tmp":

            $dirTmp = '../../upload/tmp/';

            echo Methods::nextDir($dirTmp);
            break;

        case "profile-picture-load":

            $user = unserialize($_SESSION["user"]);
            $user->load();
            if (!is_null($user->picture)) echo str_replace("../../", "", $user->picture);
            else echo 0;
            break;
    }
}