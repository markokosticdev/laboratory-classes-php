<?php

$action = (isset($_GET['action'])) ? $_GET['action'] : "";

switch ($action) {
    case "home-start":
        ?>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1>Home</h1>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2>Exercises</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th colspan="4">Exercise</th>
                    </tr>
                    </thead>
                    <tbody id="exercise-week">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2>Subjects</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th>Subject</th>
                        <th>Assistants</th>
                    </tr>
                    </thead>
                    <tbody id="subject-all">

                    </tbody>
                </table>
            </div>
        </div>

        <?php
        break;
    case "home-subject":
        ?>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 id="subject-title">Subject</h1>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th colspan="2">Subject</th>
                    </tr>
                    </thead>
                    <tbody id="subject-one">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th>Exercises</th>
                    </tr>
                    </thead>
                    <tbody id="subject-exercise">

                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th>Assistants</th>
                    </tr>
                    </thead>
                    <tbody id="subject-assistant">

                    </tbody>
                </table>
            </div>
        </div>

        <?php
        break;
    case "home-exercise":
        ?>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 id="exercise-title">Exercise</h1>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th colspan="2">Exercise</th>
                    </tr>
                    </thead>
                    <tbody id="exercise-one">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th>Terms</th>
                    </tr>
                    </thead>
                    <tbody id="exercise-term">

                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th>Materials</th>
                    </tr>
                    </thead>
                    <tbody id="exercise-material">

                    </tbody>
                </table>
            </div>
        </div>

        <?php
        break;
    case "home-term":
        ?>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 id="term-name">Term</h1>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th colspan="2">Term</th>
                    </tr>
                    </thead>
                    <tbody id="term-one">

                    </tbody>
                </table>
            </div>
        </div>

        <?php
        break;
    case "home-assistant":
        ?>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 id="assistant-name">Assistant</h1>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-faded">
                        <th colspan="2">Assistant</th>
                    </tr>
                    </thead>
                    <tbody id="assistant-one">

                    </tbody>
                </table>
            </div>
        </div>

        <?php
        break;
}
