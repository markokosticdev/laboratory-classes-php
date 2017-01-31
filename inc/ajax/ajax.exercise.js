/////exercise-add/////

(function ($) {
    $.exerciseAdd = function () {
        var form = "#exercise-add";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=exercise-subject-load-all", function (response, status) {

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
                }
            });

            $("html").getNiceScroll().resize();

            $(form).validate({
                submitHandler: function () {

                    if ($("#materials").val()) {


                        $.post("inc/ajax/ajax." + name + ".php?action=exercise-material-tmp", function (response, status) {

                            var dirName = response;

                            $(form).ajaxSubmit({
                                type: 'POST',
                                url: 'inc/ajax/ajax.' + name + '.php?action=exercise-material-add',
                                data: {dir: dirName},
                                dataType: 'json',

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
                                    $.each($('#materials').prop("files"), function (key, val) {
                                        data.push({name: "materials[]", value: val.name});
                                    });
                                    data.push({name: "dir", value: dirName});

                                    $.post("inc/ajax/ajax." + name + ".php?action=" + action, $.param(data), function (response, status) {
                                        if (response == 1) {
                                            $(".alert").remove();
                                            $(form).formAlert("alert-success", "Exercise has been created!");
                                            $("html, body").animate({scrollTop: 0}, "slow");
                                            setTimeout(function () {
                                                $.exerciseAdd();
                                            }, 2000);
                                        }
                                        else if (response == 0) {
                                            $(".alert").remove();
                                            $(form).formAlert("alert-danger", "Exercise has not been created!");
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
                                $(form).formAlert("alert-success", "Exercise has been created!");
                                $("html, body").animate({scrollTop: 0}, "slow");
                                setTimeout(function () {
                                    $.exerciseAdd();
                                }, 2000);
                            }
                            else if (response == 0) {
                                $(".alert").remove();
                                $(form).formAlert("alert-danger", "Exercise has not been created!");
                                $("html, body").animate({scrollTop: 0}, "slow");
                            }
                        });
                    }
                },
                rules: {
                    subject: {
                        required: true,
                        valueNotEquals: ""
                    },
                    title: {
                        required: true,
                        validateExerciseTitle: true
                    },
                    number: {
                        required: true
                    },
                    description: {},
                    "materials[]": {}
                },
                messages: {
                    subject: {
                        required: "Choose Subject",
                        valueNotEquals: "Choose Subject"
                    },
                    title: {
                        required: "Enter Name",
                        validateExerciseTitle: "Exercise with the same Name already exists"
                    },
                    number: {
                        required: "Enter Number"
                    },
                    description: {},
                    "materials[]": {}
                }
            });
        });

        return this;
    };
})(jQuery);


/////exercise-edit/////

(function ($) {
    $.exerciseEdit = function () {
        var form = "#exercise-edit";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=exercise-subject-load-all", function (response, status) {

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
                }
            });

            $.getJSON("inc/ajax/ajax." + name + ".php?action=exercise-subject-load-all", function (response, status) {

                if (response != 0) {
                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });
                        $("#exercise-subject").append('<option value="' + subjects.subjectId + '">' + subjects.title + '</option>');
                    });
                }

                var changed1 = false;
                var formGroup = $(".form-group:gt(1)");
                formGroup.hide();

                $("body").on("change", "#exercise-subject", function () {

                    (changed1) ? formGroup.hide("slow") : changed1 = true;
                    (changed1) ? $("#exercise").children(":first").prop("selected", true) : changed1 = true;

                    $.getJSON("inc/ajax/ajax." + name + ".php?action=exercise-load-selected", {subjectId: $("#exercise-subject").val()}, function (response, status) {

                        $("#exercise").children(":not(:first)").remove();

                        if (response != 0) {

                            var exercises = {};
                            $.each(response, function (exercise, object) {
                                $.each(object, function (key, value) {
                                    if (value != "NULL") {
                                        exercises[key] = value;
                                    }
                                    else exercises[key] = "";
                                });
                                $("#exercise").append('<option value="' + exercises.exerciseId + '">' + exercises.title + ' ' + exercises.number + '</option>');
                            });
                        }

                        $("#exercise").prop("disabled", false);

                        var changed2 = false;

                        $("body").on("change", "#exercise", function () {

                            (changed2) ? formGroup.hide("slow") : changed2 = true;


                            $.getJSON("inc/ajax/ajax." + name + ".php?action=exercise-load-one", {exerciseId: $("#exercise").val()}, function (response, status) {

                                if (response != 0) {
                                    var exercise = {};
                                    $.each(response, function (key, value) {
                                        if (value != "NULL") {
                                            exercise[key] = value;
                                        }
                                        else exercise[key] = "";
                                    });


                                    $.each(exercise.subject, function (key, value) {
                                        if (value != "NULL") {
                                            subject[key] = value;
                                        }
                                        else subject[key] = "";
                                    });

                                    $("#subject").find("[value='" + subject.subjectId + "']").prop("selected", true);
                                    $("#title").val(exercise.title);
                                    $("#number").val(exercise.number);
                                    $("#description").val(exercise.description);

                                    $("#materials-old").children().remove();

                                    if (typeof exercise.materials !== 'undefined' && exercise.materials.length > 0) {

                                        var materialsOld = {};
                                        var i = 0;
                                        $.each(exercise.materials, function (exercise, object) {
                                            $.each(object, function (key, value) {
                                                if (value != "NULL") {
                                                    materialsOld[key] = value;
                                                }
                                                else materialsOld[key] = "";
                                            });


                                            if (i == 0) {
                                                $("#materials-old").append('<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Uploaded Materials</label>').append('<label class="col-xs-12 col-sm-8 col-md-9 col-lg-10 col-form-label material"></label>');
                                                $(".material:eq(" + i + ")").append('<i class="fa ' + materialsOld.extension + '" aria-hidden="true"></i> <a class="material-link" data-materialid="' + materialsOld.materialId + '" data-extension="' + materialsOld.extension + '" >' + materialsOld.title + '.' + materialsOld.extension + '</a>&nbsp;&nbsp;&nbsp;')
                                                    .append('<i class="fa fa-pencil edit" aria-hidden="true"></i>&nbsp;<i class="fa fa-trash-o delete" aria-hidden="true"></i>');
                                            }
                                            else {
                                                $("#materials-old").append('<label class="offset-sm-4 offset-md-3 offset-lg-2 col-xs-12 col-sm-8 col-md-9 col-lg-10 col-form-label material"></label>');
                                                $(".material:eq(" + i + ")").append('<i class="fa ' + materialsOld.extension + '" aria-hidden="true"></i> <a class="material-link" data-materialid="' + materialsOld.materialId + '" data-extension="' + materialsOld.extension + '">' + materialsOld.title + '.' + materialsOld.extension + '</a>&nbsp;&nbsp;&nbsp;')
                                                    .append('<i class="fa fa-pencil edit" aria-hidden="true"></i>&nbsp;<i class="fa fa-trash-o delete" aria-hidden="true"></i>');
                                            }
                                            i++;

                                        });


                                        $("body").on("click touchstart", ".edit", function () {

                                            if ($(this).parent().is(".material:first")) {
                                                $(this).parent().hide();
                                                $(this).parent().after('<div class="col-xs-12 col-sm-8 col-md-9 col-lg-10 material-edit"><input class="form-control" type="text" value="' + $(this).parent().children(".material-link").text().replace(/\.[^/.]+$/, "") + '" id="material-edit"/></div>');
                                                $(this).parent().next(".material-edit").children("input").trigger("focus");
                                            }
                                            else {
                                                $(this).parent().hide();
                                                $(this).parent().after('<div class="offset-sm-4 offset-md-3 offset-lg-2 col-xs-12 col-sm-8 col-md-9 col-lg-10 material-edit"><input class="form-control" type="text" value="' + $(this).parent().children(".material-link").text().replace(/\.[^/.]+$/, "") + '" id="material-edit"/></div>');
                                                $(this).parent().next(".material-edit").children("input").trigger("focus");
                                            }

                                        }).on("focusout", "#material-edit", function () {

                                            $(this).parent().prev(".material").children(".material-link").text($(this).val() + '.' + $(this).parent().prev(".material").children(".material-link").data("extension"));
                                            $(this).parent().prev(".material").show();
                                            $(this).remove();

                                        }).on("click touchstart", ".delete", function () {

                                            if ($(this).parent().is(".material:first")) {

                                                if (!$(this).parent().next().length) {
                                                    $("#materials-old").remove();
                                                }
                                                else {
                                                    $(this).parent().next().removeClass("offset-sm-4 offset-md-3 offset-lg-2");
                                                }
                                                $(this).parent().remove();
                                            }
                                            else {

                                                $(this).parent().remove();
                                            }

                                        });

                                        $("#materials-old").show();
                                    }
                                    else {

                                        $("#materials-old").hide();
                                    }

                                    formGroup.show("slow", function () {
                                        $("html").getNiceScroll().resize();
                                    });

                                    $(form).validate({
                                        submitHandler: function () {

                                            if ($("#materials").val()) {


                                                $.post("inc/ajax/ajax." + name + ".php?action=exercise-material-tmp", function (response, status) {

                                                    var dirName = response;

                                                    $(form).ajaxSubmit({
                                                        type: 'POST',
                                                        url: 'inc/ajax/ajax.' + name + '.php?action=exercise-material-add',
                                                        data: {dir: dirName},
                                                        dataType: 'json',

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
                                                            $.each($('#materials').prop("files"), function (key, val) {
                                                                data.push({name: "materials[]", value: val.name});
                                                            });
                                                            data.push({name: "dir", value: dirName});

                                                            $("#materials-old .material a").each(function (k, v) {
                                                                data.push({
                                                                    name: "materials-old[title][" + k + "]",
                                                                    value: $(this).text()
                                                                });
                                                                data.push({
                                                                    name: "materials-old[materialId][" + k + "]",
                                                                    value: $(this).data("materialid")
                                                                });
                                                            });


                                                            $.post("inc/ajax/ajax." + name + ".php?action=" + action, $.param(data), function (response, status) {
                                                                if (response == 1) {
                                                                    $(".alert").remove();
                                                                    $(form).formAlert("alert-success", "Exercise has been updated!");
                                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                                    setTimeout(function () {
                                                                        $.exerciseEdit();
                                                                    }, 2000);
                                                                }
                                                                else if (response == 0) {
                                                                    $(".alert").remove();
                                                                    $(form).formAlert("alert-danger", "Exercise has not been updated!");
                                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                                }
                                                            });
                                                        }
                                                    });
                                                });
                                            }
                                            else {

                                                var data = $(form).serializeArray();

                                                $("#materials-old .material a").each(function (k, v) {
                                                    data.push({
                                                        name: "materials-old[title][" + k + "]",
                                                        value: $(this).text()
                                                    });
                                                    data.push({
                                                        name: "materials-old[materialId][" + k + "]",
                                                        value: $(this).data("materialid")
                                                    });
                                                });

                                                $.post("inc/ajax/ajax." + name + ".php?action=" + action, $.param(data), function (response, status) {

                                                    if (response == 1) {
                                                        $(".alert").remove();
                                                        $(form).formAlert("alert-success", "Exercise has been updated!");
                                                        $("html, body").animate({scrollTop: 0}, "slow");
                                                        setTimeout(function () {
                                                            $.exerciseEdit();
                                                        }, 2000);
                                                    }
                                                    else if (response == 0) {
                                                        $(".alert").remove();
                                                        $(form).formAlert("alert-danger", "Exercise has not been updated!");
                                                        $("html, body").animate({scrollTop: 0}, "slow");
                                                    }
                                                });
                                            }
                                        },
                                        rules: {
                                            "exercise-subject": {
                                                required: true,
                                                valueNotEquals: ""
                                            },
                                            exercise: {
                                                required: true,
                                                valueNotEquals: ""
                                            },
                                            subject: {
                                                required: true
                                            },
                                            title: {
                                                required: true
                                            },
                                            number: {
                                                required: true
                                            },
                                            description: {},
                                            "materials[]": {}
                                        },
                                        messages: {
                                            "exercise-subject": {
                                                required: "Choose Subject",
                                                valueNotEquals: "Choose Subject"
                                            },
                                            exercise: {
                                                required: "Choose Exercise",
                                                valueNotEquals: "Choose Exercise"
                                            },
                                            subject: {
                                                required: "Choose Subject"
                                            },
                                            title: {
                                                required: "Enter Name"
                                            },
                                            number: {
                                                required: "Enter Number"
                                            },
                                            description: {},
                                            "materials[]": {}
                                        }
                                    });
                                }
                            });
                        });
                    });
                });
            });
        });
    };
})(jQuery);


/////exercise-delete/////

(function ($) {
    $.exerciseDelete = function () {
        var form = "#exercise-delete";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {
            $.getJSON("inc/ajax/ajax." + name + ".php?action=exercise-subject-load-all", function (response, status) {

                if (response != 0) {
                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });
                        $("#exercise-subject").append('<option value="' + subjects.subjectId + '">' + subjects.title + '</option>');

                        var changed1 = false;
                        var formGroup = $(".form-group:gt(1)");
                        formGroup.hide();

                        $("body").on("change", "#exercise-subject", function () {

                            (changed1) ? $("#exercise").children(":first").prop("selected", true) : changed1 = true;

                            $.getJSON("inc/ajax/ajax." + name + ".php?action=exercise-load-selected", {subjectId: $("#exercise-subject").val()}, function (response, status) {

                                if (response != 0) {

                                    $("#exercise").children(":not(:first)").remove();

                                    var exercises = {};
                                    $.each(response, function (exercise, object) {
                                        $.each(object, function (key, value) {
                                            if (value != "NULL") {
                                                exercises[key] = value;
                                            }
                                            else exercises[key] = "";
                                        });
                                        $("#exercise").append('<option value="' + exercises.exerciseId + '">' + exercises.title + ' ' + exercises.number + '</option>');
                                    });
                                }

                                $("#exercise").prop("disabled", false);

                                var changed2 = false;

                                $("body").on("change", "#exercise", function () {

                                    (changed2) ? formGroup.hide("slow") : changed2 = true;

                                    formGroup.show("slow", function () {

                                        $("html").getNiceScroll().resize();
                                    });
                                });

                                $(form).validate({
                                    submitHandler: function () {

                                        if (confirmDialog("Delete Exercise?")) {

                                            $.post("inc/ajax/ajax." + name + ".php?action=" + action, $(form).serialize(), function (response, status) {

                                                if (response == 1) {
                                                    $(".alert").remove();
                                                    $(form).formAlert("alert-success", "Exercise has been deleted!");
                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                    setTimeout(function () {
                                                        $.exerciseDelete();
                                                    }, 2000);

                                                }
                                                else if (response == 0) {
                                                    $(".alert").remove();
                                                    $(form).formAlert("alert-danger", "Exercise has not been deleted!");
                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                }
                                            });
                                        }
                                    },
                                    rules: {
                                        "exercise-subject": {
                                            required: true,
                                            valueNotEquals: ""
                                        },
                                        exercise: {
                                            required: true,
                                            valueNotEquals: ""
                                        },
                                    },
                                    messages: {
                                        "exercise-subject": {
                                            required: "Choose Subject",
                                            valueNotEquals: "Choose Subject"
                                        },
                                        exercise: {
                                            required: "Choose Exercise",
                                            valueNotEquals: "Choose Exercise"
                                        }
                                    }
                                });
                            });
                        });
                    });
                }
            });
        });
    };
})(jQuery);