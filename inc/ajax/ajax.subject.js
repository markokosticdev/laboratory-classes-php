/////subject-add/////

(function ($) {
    $.subjectAdd = function () {
        var form = "#subject-add";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=subject-department-load-all", function (response, status) {

                if (response != 0) {
                    var departments = {};
                    $.each(response, function (department, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                departments[key] = value;
                            }
                            else departments[key] = "";
                        });
                        $("#departments").append('<option value="' + departments.departmentId + '">' + departments.acronym + ' - ' + departments.title + '</option>');
                    });
                    /*$("#departments").niceScroll({
                     cursorcolor:"#373a3c",
                     cursorwidth:"10px",
                     cursorborder:"none",
                     cursorborderradius:"0px"
                     });*/
                }
            });

            $.getJSON("inc/ajax/ajax." + name + ".php?action=subject-assistant-load-all", function (response, status) {

                if (response != 0) {
                    var assistants = {};
                    $.each(response, function (assistant, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                assistants[key] = value;
                            }
                            else assistants[key] = "";
                        });
                        $("#assistants").append('<option value="' + assistants.userId + '">' + assistants.fname + ' ' + assistants.lname + '</option>');
                    });
                    /*$("#assistants").niceScroll({
                     cursorcolor:"#373a3c",
                     cursorwidth:"10px",
                     cursorborder:"none",
                     cursorborderradius:"0px"
                     });*/
                }
            });

            $("html").getNiceScroll().resize();

            $(form).validate({
                submitHandler: function () {

                    $.post("inc/ajax/ajax." + name + ".php?action=" + action, $(form).serialize(), function (response, status) {

                        if (response == 1) {
                            $(".alert").remove();
                            $(form).formAlert("alert-success", "Subject has been created!");
                            $("html, body").animate({scrollTop: 0}, "slow");
                            setTimeout(function () {
                                $.subjectAdd();
                            }, 2000);
                        }
                        else if (response == 0) {
                            $(".alert").remove();
                            $(form).formAlert("alert-danger", "Subject has not been created!");
                            $("html, body").animate({scrollTop: 0}, "slow");
                        }
                    });
                },
                rules: {
                    title: {
                        required: true,
                        validateSubjectTitle: true
                    },
                    description: {},
                    "departments[]": {
                        required: true
                    },
                    "assistants[]": {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Enter Name",
                        validateSubjectTitle: "Subject with the same Name already exists"
                    },
                    description: {},
                    "departments[]": {
                        required: "Choose Departments"
                    },
                    "assistants[]": {
                        required: "Choose Assistants"
                    }
                }
            });
        });
    };
})(jQuery);


/////subject-edit/////

(function ($) {
    $.subjectEdit = function () {
        var form = "#subject-edit";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {
            $.getJSON("inc/ajax/ajax." + name + ".php?action=subject-load-all", function (response, status) {

                if (response != 0) {
                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });
                        $("#subject").append('<option value="' + subjects.subjectId + '">' + subjects.title + '</option>');
                    });

                    $.getJSON("inc/ajax/ajax." + name + ".php?action=subject-department-load-all", function (response, status) {

                        if (response != 0) {
                            var departments = {};
                            $.each(response, function (department, object) {
                                $.each(object, function (key, value) {
                                    if (value != "NULL") {
                                        departments[key] = value;
                                    }
                                    else departments[key] = "";
                                });
                                $("#departments").append('<option value="' + departments.departmentId + '">' + departments.acronym + ' - ' + departments.title + '</option>');
                            });
                            /*$("#departments").niceScroll({
                             cursorcolor:"#373a3c",
                             cursorwidth:"10px",
                             cursorborder:"none",
                             cursorborderradius:"0px"
                             });*/
                        }
                    });

                    $.getJSON("inc/ajax/ajax." + name + ".php?action=subject-assistant-load-all", function (response, status) {

                        if (response != 0) {
                            var assistants = {};
                            $.each(response, function (assistant, object) {
                                $.each(object, function (key, value) {
                                    if (value != "NULL") {
                                        assistants[key] = value;
                                    }
                                    else assistants[key] = "";
                                });
                                $("#assistants").append('<option value="' + assistants.userId + '">' + assistants.fname + ' ' + assistants.lname + '</option>');
                            });
                            /*$("#assistants").niceScroll({
                             cursorcolor:"#373a3c",
                             cursorwidth:"10px",
                             cursorborder:"none",
                             cursorborderradius:"0px"
                             });*/
                        }
                    });

                    var formGroup = $(".form-group:gt(1)");
                    var changed = false;
                    formGroup.hide();

                    $("body").on("change", "#subject", function () {

                        (changed) ? formGroup.hide("slow") : changed = true;

                        $.getJSON("inc/ajax/ajax." + name + ".php?action=subject-load-one", {subjectId: $("#subject").val()}, function (response, status) {

                            if (response != 0) {
                                var subject = {};
                                $.each(response, function (key, value) {
                                    if (value != "NULL") {
                                        subject[key] = value;
                                    }
                                    else subject[key] = "";
                                });
                                $("#title").val(subject.title);
                                $("#description").val(subject.description);

                                var departments = {};
                                $.each(subject.departments, function (department, object) {
                                    $.each(object, function (key, object2) {
                                        $.each(object2, function (key, value) {
                                            if (value != "NULL") {
                                                departments[key] = value;
                                            }
                                            else departments[key] = "";
                                        });
                                        $("#departments option[value='" + departments.departmentId + "']").prop("selected", true);

                                    });
                                });

                                var assistants = {};
                                $.each(subject.assistants, function (assistant, object) {
                                    $.each(object, function (key, value) {
                                        if (value != "NULL") {
                                            assistants[key] = value;
                                        }
                                        else assistants[key] = "";
                                    });
                                    $("#assistants option[value='" + assistants.userId + "']").prop("selected", true);

                                });

                                formGroup.show("slow", function () {
                                    $("html").getNiceScroll().resize();
                                });

                                $(form).validate({
                                    submitHandler: function () {

                                        $.post("inc/ajax/ajax." + name + ".php?action=" + action, $(form).serialize(), function (response, status) {

                                            if (response == 1) {
                                                $(".alert").remove();
                                                $(form).formAlert("alert-success", "Subject has been updated!");
                                                $("html, body").animate({scrollTop: 0}, "slow");
                                                setTimeout(function () {
                                                    $.subjectEdit();
                                                }, 2000);
                                            }
                                            else if (response == 0) {
                                                $(".alert").remove();
                                                $(form).formAlert("alert-danger", "Subject has not been updated!");
                                                $("html, body").animate({scrollTop: 0}, "slow");
                                            }
                                        });
                                    },
                                    rules: {
                                        subject: {
                                            required: true,
                                            valueNotEquals: ""
                                        },
                                        title: {
                                            required: true
                                        },
                                        description: {},
                                        "departments[]": {
                                            required: true
                                        },
                                        "assistants[]": {
                                            required: true
                                        }
                                    },
                                    messages: {
                                        subject: {
                                            required: "Choose Subject",
                                            valueNotEquals: "Choose Subject"
                                        },
                                        title: {
                                            required: "Enter Name"
                                        },
                                        description: {},
                                        "departments[]": {
                                            required: "Choose Departments"
                                        },
                                        "assistants[]": {
                                            required: "Choose Assistants"
                                        }
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


/////subject-delete/////

(function ($) {
    $.subjectDelete = function () {

        var form = "#subject-delete";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=subject-load-all", function (response, status) {

                if (response != 0) {
                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });
                        $("#subject").append('<option value="' + subjects.subjectId + '">' + subjects.title + '</option>');
                    });

                    var formGroup = $(".form-group:gt(1)");
                    var changed = false;
                    formGroup.hide();

                    $("body").on("change", "#subject", function () {

                        (changed) ? formGroup.hide("slow") : changed = true;

                        formGroup.show("slow", function () {

                            $("html").getNiceScroll().resize();
                        });
                    });

                    $(form).validate({
                        submitHandler: function () {

                            if (confirmDialog("Delete Subject?")) {

                                $.post("inc/ajax/ajax." + name + ".php?action=" + action, $(form).serialize(), function (response, status) {

                                    if (response == 1) {
                                        $(".alert").remove();
                                        $(form).formAlert("alert-success", "Subject has been deleted!");
                                        $("html, body").animate({scrollTop: 0}, "slow");
                                        setTimeout(function () {
                                            $.subjectDelete();
                                        }, 2000);
                                    }
                                    else if (response == 0) {
                                        $(".alert").remove();
                                        $(form).formAlert("alert-danger", "Subject has not been deleted!");
                                        $("html, body").animate({scrollTop: 0}, "slow");
                                    }
                                });
                            }
                        },
                        rules: {
                            subject: {
                                required: true,
                                valueNotEquals: ""
                            }
                        },
                        messages: {
                            subject: {
                                required: "Choose Subject",
                                valueNotEquals: "Choose Subject"
                            }
                        }
                    });
                }
            });
        });
    };
})(jQuery);