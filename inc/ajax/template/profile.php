<?php
session_start();

if (isset($_SESSION['user'])) {

    $action = $_GET['action'];

    switch ($action) {
        case "profile-edit":
            ?>

            <form id="profile-edit">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1>Edit Profile</h1>
                        <hr/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h2>Account</h2>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Username</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="text" value="" name="username" id="username"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password1" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Password</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="password" value="" name="password1" id="password1"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password2" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Repeated
                        Password</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="password" value="" name="password2" id="password2"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">E-Mail</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="email" value="" name="email" id="email" disabled="disabled"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h2>Profile</h2>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fname" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">First Name</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="text" value="" name="fname" id="fname" disabled="disabled"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Last Name</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="text" value="" name="lname" id="lname" disabled="disabled"/>
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
                    <label for="picture" class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Picture</label>
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input class="form-control" type="file" name="picture" id="picture"/>
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
    }
}