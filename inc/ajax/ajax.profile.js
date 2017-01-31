/////profile-edit/////

(function ($) {
    $.profileEdit = function () {
        var form = "#profile-edit";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $("html").getNiceScroll().resize();

            $.getJSON("inc/ajax/ajax." + name + ".php?action=profile-load", function (response, status) {
                if (response != 0) {
                    var user = {};
                    $.each(response, function (key, value) {
                        if (value != "NULL") {
                            user[key] = value;
                        }
                        else user[key] = "";
                    });
                    $("#username").val(user.username);
                    $("#email").val(user.email);
                    $("#fname").val(user.fname);
                    $("#lname").val(user.lname);
                    $("#description").val(user.description);
                    //$("#picture").val(user.picture);

                    $(form).validate({
                        submitHandler: function () {

                            if ($("#picture").val()) {

                                $.post("inc/ajax/ajax." + name + ".php?action=profile-picture-tmp", function (response, status) {

                                    var dirName = response;

                                    $(form).ajaxSubmit({
                                        type: 'POST',
                                        url: 'inc/ajax/ajax.' + name + '.php?action=profile-picture-add',
                                        data: {dir: dirName},
                                        dataType: 'script',

                                        beforeSend: function () {
                                            $("progress").prop("hidden", false);
                                        },

                                        uploadProgress: function (event, position, total, percentComplete) {
                                            $(".progress").attr("value", percentComplete);
                                            $(".progress-bar").css("width", percentComplete + "%");
                                        },

                                        complete: function () {
                                            $(".progress").prop("hidden", true);

                                            var data = $(form).serializeArray();
                                            data.push({name: "picture", value: $('#picture').prop("files")[0].name});
                                            data.push({name: "dir", value: dirName});

                                            $.post("inc/ajax/ajax." + name + ".php?action=" + action, $.param(data), function (response, status) {
                                                if (response == 1) {
                                                    $(".alert").remove();
                                                    $(form).formAlert("alert-success", "Profile has been updated!");
                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                    $("html").getNiceScroll().resize();
                                                    $.post("inc/ajax/ajax.profile.php?action=profile-picture-load", function (response, status) {

                                                        if (response != 0) {
                                                            $(".profile-picture").attr("src", response);
                                                        }
                                                        setTimeout(function () {
                                                            $.profileEdit();
                                                        }, 2000);
                                                    });

                                                }
                                                else if (response == 0) {
                                                    $(".alert").remove();
                                                    $(form).formAlert("alert-danger", "Profile has not been updated!");
                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                    $("html").getNiceScroll().resize();
                                                }
                                            });
                                        }
                                    });
                                });
                            }
                            else {

                                $.post("inc/ajax/ajax." + name + ".php?action=" + action, $(form).serialize(), function (response, status) {

                                    if (response == 1) {
                                        $(".alert").remove();
                                        $(form).formAlert("alert-success", "Profile has been updated!");
                                        $("html, body").animate({scrollTop: 0}, "slow");
                                        setTimeout(function () {
                                            $.profileEdit();
                                        }, 2000);
                                    }
                                    else if (response == 0) {
                                        $(".alert").remove();
                                        $(form).formAlert("alert-danger", "Profile has not been updated!");
                                        $("html, body").animate({scrollTop: 0}, "slow");
                                    }
                                });
                            }
                        },
                        rules: {
                            username: {
                                required: true
                            },
                            password1: {
                                required: true,
                                minlength: 6
                            },
                            password2: {
                                required: true,
                                equalTo: "#password1"
                            },
                            email: {
                                required: true
                            },
                            fname: {
                                required: true
                            },
                            lname: {
                                required: true
                            },
                            description: {},
                            picture: {}
                        },
                        messages: {
                            username: {
                                required: "Enter Username"
                            },
                            password1: {
                                required: "Enter Password",
                                minlength: "Password should be at least 6 characters"
                            },
                            password2: {
                                required: "Enter password again",
                                equalTo: "Password and the Repeated Password are not the same"
                            },
                            email: {
                                required: "Enter E-Mail",
                                email: "Enter E-Mail in the correct format"
                            },
                            fname: {
                                required: "Enter First Name"
                            },
                            lname: {
                                required: "Enter Last Name"
                            },
                            description: {},
                            picture: {}
                        }
                    });
                }
            });
        });
    };
})(jQuery);