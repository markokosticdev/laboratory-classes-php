/////term-add/////

(function ($) {
    $.termAdd = function () {
        var form = "#term-add";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-laboratory-load-all", function (response, status) {
                if (response != 0) {
                    var laboratories = {};
                    $.each(response, function (laboratory, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                laboratories[key] = value;
                            }
                            else laboratories[key] = "";
                        });
                        $("#laboratory").append('<option value="' + laboratories.laboratoryId + '">' + laboratories.title + ' - ' + laboratories.number + '</option>');
                    });
                }
            });

            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-assistant-load-all", function (response, status) {
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

            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-subject-load-all", function (response, status) {
                if (response != 0) {
                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });
                        $("#term-subject").append('<option value="' + subjects.subjectId + '">' + subjects.title + '</option>');
                    });
                }

                var changed1 = false;

                $("body").on("change", "#term-subject", function () {

                    (changed1) ? $("#exercise").children(":first").prop("selected", true) : changed1 = true;

                    $.getJSON("inc/ajax/ajax." + name + ".php?action=term-exercise-load-selected", {subjectId: $("#term-subject").val()}, function (response, status) {
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

                    });
                });
            });

            $("html").getNiceScroll().resize();

            $(form).validate({
                submitHandler: function () {

                    $.post("inc/ajax/ajax." + name + ".php?action=" + action, $(form).serialize(), function (response, status) {

                        if (response == 1) {
                            $(".alert").remove();
                            $(form).formAlert("alert-success", "Term has been created!");
                            $("html, body").animate({scrollTop: 0}, "slow");
                            setTimeout(function () {
                                $.termAdd();
                            }, 2000);
                        }
                        else if (response == 0) {
                            $(".alert").remove();
                            $(form).formAlert("alert-danger", "Term has not been created!");
                            $("html, body").animate({scrollTop: 0}, "slow");
                        }
                    });
                },
                rules: {
                    "term-subject": {
                        required: true,
                        valueNotEquals: ""
                    },
                    exercise: {
                        required: true,
                        valueNotEquals: ""
                    },
                    datetime: {
                        required: true,
                        date: true
                    },
                    laboratory: {
                        required: true,
                        valueNotEquals: ""
                    },
                    "assistants[]": {
                        required: true,
                        valueNotEquals: ""
                    }
                },
                messages: {
                    "term-subject": {
                        required: "Choose Subject",
                        valueNotEquals: "Choose Subject"
                    },
                    exercise: {
                        required: "Choose Exercise",
                        valueNotEquals: "Choose Exercise"
                    },
                    datetime: {
                        required: "Enter Date and Time",
                        date: "Enter Date and Time in the correct format"
                    },
                    laboratory: {
                        required: "Choose Laboratory",
                        valueNotEquals: "Choose Laboratory."
                    },
                    "assistants[]": {
                        required: "Choose Assistants",
                        valueNotEquals: "Choose Assistants"
                    }
                }
            });
        });
    };
})(jQuery);


/////term-edit/////

(function ($) {
    $.termEdit = function () {
        var form = "#term-edit";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-laboratory-load-all", function (response, status) {
                if (response != 0) {
                    var laboratories = {};
                    $.each(response, function (laboratory, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                laboratories[key] = value;
                            }
                            else laboratories[key] = "";
                        });
                        $("#laboratory").append('<option value="' + laboratories.laboratoryId + '">' + laboratories.title + ' - ' + laboratories.number + '</option>');
                    });
                }
            });

            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-assistant-load-all", function (response, status) {
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

            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-subject-load-all", function (response, status) {
                if (response != 0) {
                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });
                        $("#term-subject").append('<option value="' + subjects.subjectId + '">' + subjects.title + '</option>');
                    });
                }

                var changed1 = false;
                var formGroup = $(".form-group:gt(1)");
                formGroup.hide();

                $("body").on("change", "#term-subject", function () {

                    (changed1) ? formGroup.hide("slow") : changed1 = true;
                    (changed1) ? $("#term-exercise").children(":first").prop("selected", true) : changed1 = true;
                    (changed1) ? $("#term").children(":first").prop("selected", true) : changed1 = true;

                    $.getJSON("inc/ajax/ajax." + name + ".php?action=term-exercise-load-selected", {subjectId: $("#term-subject").val()}, function (response, status) {
                        if (response != 0) {

                            $("#term-exercise").children(":not(:first)").remove();

                            var exercises = {};
                            $.each(response, function (exercise, object) {
                                $.each(object, function (key, value) {
                                    if (value != "NULL") {
                                        exercises[key] = value;
                                    }
                                    else exercises[key] = "";
                                });
                                $("#term-exercise").append('<option value="' + exercises.exerciseId + '">' + exercises.title + ' ' + exercises.number + '</option>');
                            });
                        }

                        $("#term-exercise").prop("disabled", false);

                        var changed2 = false;

                        $("body").on("change", "#term-exercise", function () {

                            (changed2) ? formGroup.hide("slow") : changed2 = true;
                            (changed2) ? $("#term").children(":first").prop("selected", true) : changed2 = true;

                            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-load-selected", {exerciseId: $("#term-exercise").val()}, function (response, status) {
                                if (response != 0) {

                                    $("#term").children(":not(:first)").remove();

                                    var terms = {};
                                    $.each(response, function (term, object) {
                                        $.each(object, function (key, value) {
                                            if (value != "NULL") {
                                                terms[key] = value;
                                            }
                                            else terms[key] = "";
                                        });
                                        $("#term").append('<option value="' + terms.termId + '">' + terms.datetime + '</option>');
                                    });
                                }

                                $("#term").prop("disabled", false);

                                var changed3 = false;

                                $("body").on("change", "#term", function () {

                                    (changed3) ? formGroup.hide("slow") : changed3 = true;

                                    $.getJSON("inc/ajax/ajax." + name + ".php?action=term-load-one", {termId: $("#term").val()}, function (response, status) {
                                        if (response != 0) {
                                            var term = {};
                                            $.each(response, function (key, value) {
                                                if (value != "NULL") {
                                                    term[key] = value;
                                                }
                                                else term[key] = "";
                                            });

                                            $("#datetime").val(term.datetime);

                                            var laboratory = {};
                                            $.each(term.laboratory, function (key, value) {
                                                if (value != "NULL") {
                                                    laboratory[key] = value;
                                                }
                                                else laboratory[key] = "";
                                            });
                                            $("#laboratory").find("[value='" + laboratory.laboratoryId + "']").prop("selected", true);

                                            var assistants = {};
                                            $.each(term.assistants, function (assistant, object) {
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
                                                            $(form).formAlert("alert-success", "Term has been updated!");
                                                            $("html, body").animate({scrollTop: 0}, "slow");
                                                            setTimeout(function () {
                                                                $.termEdit();
                                                            }, 2000);
                                                        }
                                                        else if (response == 0) {
                                                            $(".alert").remove();
                                                            $(form).formAlert("alert-danger", "Term has not been updated!");
                                                            $("html, body").animate({scrollTop: 0}, "slow");
                                                        }
                                                    });
                                                },
                                                rules: {
                                                    "term-subject": {
                                                        required: true,
                                                        valueNotEquals: ""
                                                    },
                                                    "term-exercise": {
                                                        required: true,
                                                        valueNotEquals: ""
                                                    },
                                                    term: {
                                                        required: true,
                                                        valueNotEquals: ""
                                                    },
                                                    datetime: {
                                                        required: true,
                                                        date: true
                                                    },
                                                    laboratory: {
                                                        required: true,
                                                        valueNotEquals: ""
                                                    },
                                                    "assistants[]": {
                                                        required: true,
                                                        valueNotEquals: ""
                                                    }
                                                },
                                                messages: {
                                                    "term-subject": {
                                                        required: "Choose Subject",
                                                        valueNotEquals: "Choose Subject"
                                                    },
                                                    "term-exercise": {
                                                        required: "Choose Exercise",
                                                        valueNotEquals: "Choose Exercise"
                                                    },
                                                    term: {
                                                        required: "Choose Term",
                                                        valueNotEquals: "Choose Term"
                                                    },
                                                    datetime: {
                                                        required: "Enter Date and Time",
                                                        date: "Enter Date and Time in the correct format"
                                                    },
                                                    laboratory: {
                                                        required: "Choose Laboratory",
                                                        valueNotEquals: "Choose Laboratory"
                                                    },
                                                    "assistants[]": {
                                                        required: "Choose Assistants",
                                                        valueNotEquals: "Choose Assistants"
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });
    };
})(jQuery);


/////term-delete/////

(function ($) {
    $.termDelete = function () {
        var form = "#term-delete";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-subject-load-all", function (response, status) {
                if (response != 0) {
                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });
                        $("#term-subject").append('<option value="' + subjects.subjectId + '">' + subjects.title + '</option>');
                    });
                }

                var changed1 = false;
                var formGroup = $(".form-group:gt(1)");
                formGroup.hide();

                $("body").on("change", "#term-subject", function () {

                    (changed1) ? formGroup.hide("slow") : changed1 = true;
                    (changed1) ? $("#term-exercise").children(":first").prop("selected", true) : changed1 = true;
                    (changed1) ? $("#term").children(":first").prop("selected", true) : changed1 = true;

                    $.getJSON("inc/ajax/ajax." + name + ".php?action=term-exercise-load-selected", {subjectId: $("#term-subject").val()}, function (response, status) {
                        if (response != 0) {

                            $("#term-exercise").children(":not(:first)").remove();

                            var exercises = {};
                            $.each(response, function (exercise, object) {
                                $.each(object, function (key, value) {
                                    if (value != "NULL") {
                                        exercises[key] = value;
                                    }
                                    else exercises[key] = "";
                                });
                                $("#term-exercise").append('<option value="' + exercises.exerciseId + '">' + exercises.title + ' ' + exercises.number + '</option>');
                            });
                        }

                        $("#term-exercise").prop("disabled", false);

                        var changed2 = false;

                        $("body").on("change", "#term-exercise", function () {

                            (changed2) ? formGroup.hide("slow") : changed2 = true;
                            (changed2) ? $("#term").children(":first").prop("selected", true) : changed2 = true;

                            $.getJSON("inc/ajax/ajax." + name + ".php?action=term-load-selected", {exerciseId: $("#term-exercise").val()}, function (response, status) {
                                if (response != 0) {

                                    $("#term").children(":not(:first)").remove();

                                    var terms = {};
                                    $.each(response, function (term, object) {
                                        $.each(object, function (key, value) {
                                            if (value != "NULL") {
                                                terms[key] = value;
                                            }
                                            else terms[key] = "";
                                        });
                                        $("#term").append('<option value="' + terms.termId + '">' + terms.datetime + '</option>');
                                    });
                                }

                                $("#term").prop("disabled", false);

                                var changed3 = false;

                                $("body").on("change", "#term", function () {

                                    (changed3) ? formGroup.hide("slow") : changed3 = true;

                                    formGroup.show("slow", function () {

                                        $("html").getNiceScroll().resize();
                                    });
                                });

                                $(form).validate({
                                    submitHandler: function () {

                                        if (confirmDialog("Delete Term?")) {

                                            $.post("inc/ajax/ajax." + name + ".php?action=" + action, $(form).serialize(), function (response, status) {

                                                if (response == 1) {
                                                    $(".alert").remove();
                                                    $(form).formAlert("alert-success", "Term has been deleted!");
                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                    setTimeout(function () {
                                                        $.termDelete();
                                                    }, 2000);

                                                }
                                                else if (response == 0) {
                                                    $(".alert").remove();
                                                    $(form).formAlert("alert-danger", "Term has not been deleted!");
                                                    $("html, body").animate({scrollTop: 0}, "slow");
                                                }
                                            });
                                        }
                                    },
                                    rules: {
                                        "term-subject": {
                                            required: true,
                                            valueNotEquals: ""
                                        },
                                        "term-exercise": {
                                            required: true,
                                            valueNotEquals: ""
                                        },
                                        term: {
                                            required: true,
                                            valueNotEquals: ""
                                        }
                                    },
                                    messages: {
                                        "term-subject": {
                                            required: "Choose Subject",
                                            valueNotEquals: "Choose Subject"
                                        },
                                        "term-exercise": {
                                            required: "Choose Exercise",
                                            valueNotEquals: "Choose Exercise"
                                        },
                                        term: {
                                            required: "Choose Term",
                                            valueNotEquals: "Choose Term"
                                        }
                                    }
                                });
                            });
                        });
                    });
                });
            });
        });
    };
})(jQuery);