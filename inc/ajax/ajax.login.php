<?php

spl_autoload_register(function ($class) {
    require_once "../class/class." . $class . ".php";
});

$username = trim($_POST["username"]);
$password = sha1(trim($_POST["password"]));

$userId = User::getId($username, $password);

if ($userId != false) {
    $user = User::getUser(User::getType($userId), $userId);
    $user->load();
    session_start();
    $_SESSION['user'] = serialize($user);
    echo $user->type;
} else echo 0;

