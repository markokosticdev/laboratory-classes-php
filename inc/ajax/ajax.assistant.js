/////assistant-add/////

(function ($) {
    $.assistantAdd = function () {

        var form = "#assistant-add";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $("html").getNiceScroll().resize();

            $(form).validate({
                submitHandler: function () {

                    if ($("#picture").val()) {

                        $.post("inc/ajax/ajax." + name + ".php?action=assistant-picture-tmp", function (response, status) {

                            var dirName = response;

                            $(form).ajaxSubmit({
                                type: 'POST',
                                url: 'inc/ajax/ajax.' + name + '.php?action=assistant-picture-add',
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
                                            $(form).formAlert("alert-success", "Assistant has been created!");
                                            $("html, body").animate({scrollTop: 0}, "slow");
                                            setTimeout(function () {
                                                $.assistantAdd();
                                            }, 2000);
                                        }
                                        else if (response == 0) {
                                            $(".alert").remove();
                                            $(form).formAlert("alert-danger", "Assistant has not been created!");
                                            $("html, body").animate({scrollTop: 0}, "slow");
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
                                $(form).formAlert("alert-success", "Assistant has been created!");
                                $("html, body").animate({scrollTop: 0}, "slow");
                                setTimeout(function () {
                                    $.assistantAdd();
                                }, 2000);
                            }
                            else if (response == 0) {
                                $(".alert").remove();
                                $(form).formAlert("alert-danger", "Assistant has not been created!");
                                $("html, body").animate({scrollTop: 0}, "slow");
                            }
                        });
                    }
                },
                rules: {
                    username: {
                        required: true,
                        validateUsername: true
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
                    status: {
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
                        required: "Enter Username",
                        validateUsername: "User with the same Name already exists."
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
                    status: {
                        required: "Choose Status"
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
        });
    };
})(jQuery);


/////assistant-edit/////

(function ($) {
    $.assistantEdit = function () {

        var form = "#assistant-edit";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {
            $.getJSON("inc/ajax/ajax." + name + ".php?action=assistant-load-all", function (response, status) {

                if (response != 0) {
                    var users = {};
                    $.each(response, function (user, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                users[key] = value;
                            }
                            else users[key] = "";
                        });
                        $("#assistant").append('<option value="' + users.userId + '">' + users.fname + ' ' + users.lname + '</option>');
                    });

                    var formGroup = $(".form-group:gt(1)");
                    var changed = false;
                    formGroup.hide();

                    $("body").on("change", "#assistant", function () {

                        (changed) ? formGroup.hide("slow") : changed = true;

                        $.getJSON("inc/ajax/ajax." + name + ".php?action=assistant-load-one", {userId: $("#assistant").val()}, function (response, status) {

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
                                $("#status").find("[value='" + user.status + "']").prop("selected", true);
                                $("#fname").val(user.fname);
                                $("#lname").val(user.lname);
                                $("#description").val(user.description);
                                //$("#picture").val(user.picture);

                                formGroup.show("slow", function () {
                                    $("html").getNiceScroll().resize();
                                });

                                $(form).validate({
                                    submitHandler: function () {

                                        if ($("#picture").val()) {

                                            $.post("inc/ajax/ajax." + name + ".php?action=assistant-picture-tmp", function (response, status) {

                                                var dirName = response;

                                                $(form).ajaxSubmit({
                                                    type: 'POST',
                                                    url: 'inc/ajax/ajax.' + name + '.php?action=assistant-picture-add',
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
                                                        data.push({
                                                            name: "picture",
                                                            value: $('#picture').prop("files")[0].name
                                                        });
                                                        data.push({name: "dir", value: dirName});

                                                        $.post("inc/ajax/ajax." + name + ".php?action=" + action, $.param(data), function (response, status) {
                                                            if (response == 1) {
                                                                $(".alert").remove();
                                                                $(form).formAlert("alert-success", "Assistant has been updated!");
                                                                $("html, body").animate({scrollTop: 0}, "slow");
                                                                setTimeout(function () {
                                                                    $.assistantEdit();
                                                                }, 2000);
                                                            }
                                                            else if (response == 0) {
                                                                $(".alert").remove();
                                                                $(form).formAlert("alert-danger", "Assistant has not been updated!");
                                                                $("html, body").animate({scrollTop: 0}, "slow");
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
                                                    $(form).formAlert("alert-success", "Assistant has been updated!");
                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                    setTimeout(function () {
                                                        $.assistantEdit();
                                                    }, 2000);
                                                }
                                                else if (response == 0) {
                                                    $(".alert").remove();
                                                    $(form).formAlert("alert-danger", "Assistant has not been updated!");
                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                }
                                            });
                                        }
                                    },
                                    rules: {
                                        assistant: {
                                            required: true,
                                            valueNotEquals: ""
                                        },
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
                                        status: {
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
                                        assistant: {
                                            required: "Choose Assistant",
                                            valueNotEquals: "Choose Assistant"
                                        },
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
                                        status: {
                                            required: "Choose Status"
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
                }
            });
        });
    };
})(jQuery);


/////assistant-delete/////

(function ($) {
    $.assistantDelete = function () {
        var form = "#assistant-delete";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=assistant-load-all", function (response, status) {

                if (response != 0) {
                    var users = {};
                    $.each(response, function (user, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                users[key] = value;
                            }
                            else users[key] = "";
                        });
                        $("#assistant").append('<option value="' + users.userId + '">' + users.fname + ' ' + users.lname + '</option>');
                    });

                    var formGroup = $(".form-group:gt(1)");
                    var changed = false;
                    formGroup.hide();

                    $("body").on("change", "#assistant", function () {

                        (changed) ? formGroup.hide("slow") : changed = true;

                        formGroup.show("slow", function () {
                            $("html").getNiceScroll().resize();

                        });
                    });

                    $(form).validate({
                        submitHandler: function () {

                            if (confirmDialog("Delete Assistant?")) {

                                $.post("inc/ajax/ajax." + name + ".php?action=" + action, $(form).serialize(), function (response, status) {

                                    if (response == 1) {
                                        $(".alert").remove();
                                        $(form).formAlert("alert-success", "Assistant has been deleted!");
                                        $("html, body").animate({scrollTop: 0}, "slow");
                                        setTimeout(function () {
                                            $.assistantDelete();
                                        }, 2000);
                                    }
                                    else if (response == 0) {
                                        $(".alert").remove();
                                        $(form).formAlert("alert-danger", "Assistant has not been deleted!");
                                        $("html, body").animate({scrollTop: 0}, "slow");
                                    }
                                });
                            }
                        },
                        rules: {
                            assistant: {
                                required: true,
                                valueNotEquals: ""
                            }
                        },
                        messages: {
                            assistant: {
                                required: "Choose Assistant",
                                valueNotEquals: "Choose Assistant"
                            }
                        }
                    });
                }
            });
        });
    };
})(jQuery);