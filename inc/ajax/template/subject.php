<?php
session_start();

if (isset($_SESSION['user'])) {

    $action = $_GET['action'];

    switch ($action) {
        case "subject-add":
            ?>

            <form id="subject-add">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Add Subject</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Title</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="text" value="" name="title" id="title"/>
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
                    <label for="departments"
                           class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Departments</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="departments[]" id="departments" multiple="multiple">
                            <option value="" disabled="disabled" selected="selected">Choose Departments</option>
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
        case "subject-edit":
            ?>

            <form id="subject-edit">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Edit Subject</h1>
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
                    <label for="description"
                           class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Description</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="departments"
                           class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Departments</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="departments[]" id="departments" multiple="multiple">
                            <option value="" disabled="disabled" selected="selected">Choose Departments</option>
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
        case "subject-delete":
            ?>

            <form id="subject-delete">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Delete Subject</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Subject</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <select class="form-control" name="subject" id="subject">
                            <option value="" disabled="disabled" selected="selected">Choose Subject</option>
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