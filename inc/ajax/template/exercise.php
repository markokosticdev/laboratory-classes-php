<?php
session_start();

if (isset($_SESSION['user'])) {

    $action = $_GET['action'];

    switch ($action) {
        case "exercise-add":
            ?>

            <form id="exercise-add" enctype="multipart/form-data">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Add Exercise</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="subject" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Subject</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="subject" id="subject">
                            <option value="" disabled="disabled" selected="selected">Choose Subject</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Title</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="text" value="" name="title" id="title"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="number" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Number</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="number" value="" name="number" id="number"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description"
                           class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Description</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="materials" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Materials</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" multiple="multiple" type="file" name="materials[]" id="materials"/>
                    </div>
                    <div class="hidden-xs col-sm-4 col-md-3 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <progress class="progress" value="0" max="100" aria-describedby="example-caption-6"
                                  hidden="hidden">
                            <div class="progress">
                                <span class="progress-bar" style="width: 0%;"></span>
                            </div>
                        </progress>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="hidden-xs hidden-sm col-md-4 col-lg-6">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <input class="form-control" type="reset" value="Reset" id="reset"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <input class="form-control" type="submit" value="Submit" id="submit"/>
                    </div>
                </div>
            </form>

            <?php
            break;
        case "exercise-edit":
            ?>

            <form id="exercise-edit" enctype="multipart/form-data">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Edit Exercise</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="subject" class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label">Exercise</label>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <select class="form-control" id="exercise-subject">
                            <option value="" disabled="disabled" selected="selected">Choose Subject</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-5">
                        <select class="form-control" disabled="disabled" name="exercise" id="exercise">
                            <option value="" disabled="disabled" selected="selected">Choose Exercise</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="subject" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Subject</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="subject" id="subject">
                            <option value="" disabled="disabled" selected="selected">Choose Subject</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Title</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="text" value="" name="title" id="title"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="number" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Number</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="number" value="" name="number" id="number"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description"
                           class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Description</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                    </div>
                </div>
                <div class="form-group row" id="materials-old">

                </div>
                <div class="form-group row">
                    <label for="materials" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Materials</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" multiple="multiple" type="file" name="materials[]" id="materials"/>
                    </div>
                    <div class="hidden-xs col-sm-4 col-md-3 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <progress class="progress" value="0" max="100" aria-describedby="example-caption-6"
                                  hidden="hidden">
                            <div class="progress">
                                <span class="progress-bar" style="width: 0%;"></span>
                            </div>
                        </progress>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="hidden-xs hidden-sm col-md-4 col-lg-6">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <input class="form-control" type="reset" value="Reset" id="reset"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <input class="form-control" type="submit" value="Submit" id="submit"/>
                    </div>
                </div>
            </form>

            <?php
            break;
        case "exercise-delete":
            ?>

            <form id="exercise-delete">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Delete Exercise</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="subject" class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label">Exercise</label>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <select class="form-control" id="exercise-subject">
                            <option value="" disabled="disabled" selected="selected">Choose Subject</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-5">
                        <select class="form-control" disabled="disabled" name="exercise" id="exercise">
                            <option value="" disabled="disabled" selected="selected">Choose Exercise</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="hidden-xs hidden-sm col-md-4 col-lg-6">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <input class="form-control" type="reset" value="Reset" id="reset"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <input class="form-control" type="submit" value="Submit" id="submit"/>
                    </div>
                </div>
            </form>

            <?php
            break;
    }
}