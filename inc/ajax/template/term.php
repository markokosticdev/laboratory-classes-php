<?php
session_start();

if (isset($_SESSION['user'])) {

    $action = $_GET['action'];

    switch ($action) {
        case "term-add":
            ?>

            <form id="term-add">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Add Term</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exercise" class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label">Exercise</label>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <select class="form-control" name="term-subject" id="term-subject">
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
                    <label for="datetime" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Datetime</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="datetime-local" value="" name="datetime" id="datetime"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lab" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Laboratory</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="laboratory" id="laboratory">
                            <option value="" disabled="disabled" selected="selected">Choose Laboratory</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="assistants"
                           class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Assistants</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="assistants[]" id="assistants" multiple="multiple">
                            <option value="" disabled="disabled" selected="selected">Choose Assistants</option>
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
        case "term-edit":
            ?>

            <form id="term-edit">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Edit Term</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="term" class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label">Term</label>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                        <select class="form-control" name="term-subject" id="term-subject">
                            <option value="" disabled="disabled" selected="selected">Choose Subject</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                        <select class="form-control" disabled="disabled" name="term-exercise" id="term-exercise">
                            <option value="" disabled="disabled" selected="selected">Choose Exercise</option>
                        </select>
                    </div>
                    <div class="hidden-xs-down hidden-sm-down col-md-3 hidden-lg-up">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-3">
                        <select class="form-control" disabled="disabled" name="term" id="term">
                            <option value="" disabled="disabled" selected="selected">Choose Term</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="datetime" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Datetime</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="datetime-local" value="" name="datetime" id="datetime"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lab" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Laboratory</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="laboratory" id="laboratory">
                            <option value="" disabled="disabled" selected="selected">Choose Laboratory</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="assistants"
                           class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Assistants</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="assistants[]" id="assistants" multiple="multiple">
                            <option value="" disabled="disabled" selected="selected">Choose Assistants</option>
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
        case "term-delete":
            ?>

            <form id="term-delete">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Delete Term</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="term" class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label">Term</label>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                        <select class="form-control" name="term-subject" id="term-subject">
                            <option value="" disabled="disabled" selected="selected">Choose Subject</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                        <select class="form-control" disabled="disabled" name="term-exercise" id="term-exercise">
                            <option value="" disabled="disabled" selected="selected">Choose Exercise</option>
                        </select>
                    </div>
                    <div class="hidden-xs-down hidden-sm-down col-md-3 hidden-lg-up">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-3">
                        <select class="form-control" disabled="disabled" name="term" id="term">
                            <option value="" disabled="disabled" selected="selected">Choose Term</option>
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