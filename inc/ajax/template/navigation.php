<?php

spl_autoload_register(function ($class) {
    require_once "../../class/class." . $class . ".php";
});

session_start();

$user = unserialize($_SESSION["user"]);

$type = (isset($_SESSION["user"])) ? $user->type : 0;

switch ($type) {
    case 1:
        ?>

        <div class="container navbar-container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbar-nav-dropdown" aria-controls="navbar-nav-dropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href=".">
                <img src="res/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt=""><span
                        class="hidden-xs-down">Laboratory Classes</span><span class="hidden-sm-up">LC</span>
            </a>
            <div class="collapse navbar-collapse" id="navbar-nav-dropdown">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a id="home-start-link" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="assistant-dropdown" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Assistants
                        </a>
                        <div class="dropdown-menu" aria-labelledby="assistant-dropdown">
                            <a class="dropdown-item" id="assistant-add-link">Add Assistant</a>
                            <a class="dropdown-item" id="assistant-edit-link">Edit Assistant</a>
                            <a class="dropdown-item" id="assistant-delete-link">Delete Assistant</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="subject-dropdown" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Subjects
                        </a>
                        <div class="dropdown-menu" aria-labelledby="subject-dropdown">
                            <a class="dropdown-item" id="subject-add-link">Add Subject</a>
                            <a class="dropdown-item" id="subject-edit-link">Edit Subject</a>
                            <a class="dropdown-item" id="subject-delete-link">Delete Subject</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="exercise-dropdown" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Exercises
                        </a>
                        <div class="dropdown-menu" aria-labelledby="exercise-dropdown">
                            <a class="dropdown-item" id="exercise-add-link">Add Exercise</a>
                            <a class="dropdown-item" id="exercise-edit-link">Edit Exercise</a>
                            <a class="dropdown-item" id="exercise-delete-link">Delete Exercise</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="term-dropdown" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Terms
                        </a>
                        <div class="dropdown-menu" aria-labelledby="term-dropdown">
                            <a class="dropdown-item" id="term-add-link">Add Term</a>
                            <a class="dropdown-item" id="term-edit-link">Edit Term</a>
                            <a class="dropdown-item" id="term-delete-link">Delete Term</a>
                        </div>
                    </li>
                    <li class="nav-item hidden-sm-up">
                        <a id="profile-link" class="nav-link">Profile</a>
                    </li>
                </ul>
                <form class="form-inline" id="logout-form">
                    <a class="btn nav-profile" id="profile-link">
                        <img src="res/img/profile.png" class="profile-picture"/>
                    </a>
                    <button class="btn btn-secondary" type="button" id="logout">Logout</button>
                </form>
            </div>
        </div>

        <?php
        break;
    case 2:
        ?>

        <div class="container navbar-container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbar-nav-dropdown" aria-controls="navbar-nav-dropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href=".">
                <img src="res/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt=""><span
                        class="hidden-xs-down">Laboratory Classes</span><span class="hidden-sm-up">LC</span>
            </a>
            <div class="collapse navbar-collapse" id="navbar-nav-dropdown">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a id="home-start-link" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="subject-dropdown" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Subjects
                        </a>
                        <div class="dropdown-menu" aria-labelledby="subject-dropdown">
                            <a class="dropdown-item" id="subject-edit-link">Edit Subject</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="exercise-dropdown" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Exercises
                        </a>
                        <div class="dropdown-menu" aria-labelledby="exercise-dropdown">
                            <a class="dropdown-item" id="exercise-add-link">Add Exercise</a>
                            <a class="dropdown-item" id="exercise-edit-link">Edit Exercise</a>
                            <a class="dropdown-item" id="exercise-delete-link">Delete Exercise</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="term-dropdown" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Terms
                        </a>
                        <div class="dropdown-menu" aria-labelledby="term-dropdown">
                            <a class="dropdown-item" id="term-add-link">Add Term</a>
                            <a class="dropdown-item" id="term-edit-link">Edit Term</a>
                            <a class="dropdown-item" id="term-delete-link">Delete Term</a>
                        </div>
                    </li>
                    <li class="nav-item hidden-sm-up">
                        <a id="profile-link" class="nav-link">Profile</a>
                    </li>
                </ul>
                <form class="form-inline" id="logout-form">
                    <a class="btn nav-profile" id="profile-link">
                        <img src="res/img/profile.png" class="profile-picture"/>
                    </a>
                    <button class="btn btn-secondary" type="button" id="logout">Logout</button>
                </form>
            </div>
        </div>

        <?php
        break;
    case 3:
        ?>

        <div class="container navbar-container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbar-nav-dropdown" aria-controls="navbar-nav-dropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href=".">
                <img src="res/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt=""><span
                        class="hidden-xs-down">Laboratory Classes</span><span class="hidden-sm-up">LC</span>
            </a>
            <div class="collapse navbar-collapse" id="navbar-nav-dropdown">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a id="home-start-link" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item hidden-sm-up">
                        <a id="profile-link" class="nav-link">Profile</a>
                    </li>
                </ul>
                <form class="form-inline" id="logout-form">
                    <a class="btn nav-profile" id="profile-link">
                        <img src="res/img/profile.png" class="profile-picture"/>
                    </a>
                    <button class="btn btn-secondary" type="button" id="logout">Logout</button>
                </form>
            </div>
        </div>

        <?php
        break;
    default:
        ?>

        <div class="container navbar-container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbar-nav-dropdown" aria-controls="navbar-nav-dropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href=".">
                <img src="res/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt=""><span
                        class="hidden-xs-down">Laboratory Classes</span><span class="hidden-sm-up">LC</span>
            </a>
            <div class="collapse navbar-collapse" id="navbar-nav-dropdown">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a id="home-start-link" class="nav-link">Home</a>
                    </li>
                </ul>
                <form class="form-inline" id="login-form">
                    <input class="form-control " type="text" id="username" placeholder="Корисничко име"
                           autocomplete="off" autofocus="autofocus"/>
                    <input class="form-control" type="password" id="password" placeholder="Корисничка лозинка"
                           autocomplete="off"/>
                    <button class="btn btn-secondary" type="button" id="login">Login</button>
                </form>
            </div>
        </div>

        <?php
}