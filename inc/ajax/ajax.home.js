/////home-start/////

(function ($) {
    $.homeStart = function () {
        var form = "#home-start";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=home-start", function (response, status) {

                if (response != 0) {

                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });

                        var exercises = {};
                        var exercisesTd = "";
                        $.each(subjects.exercises, function (exercise, object) {
                            $.each(object, function (key, value) {
                                if (value != "NULL") {
                                    exercises[key] = value;
                                }
                                else exercises[key] = "";
                            });

                            var terms = {};
                            var termsTd = "";
                            $.each(exercises.terms, function (term, object) {
                                $.each(object, function (key, value) {
                                    if (value != "NULL") {
                                        terms[key] = value;
                                    }
                                    else terms[key] = "";
                                });

                                var assistants = {};
                                var assistantsTd = "";
                                $.each(terms.assistants, function (assistant, object) {
                                    $.each(object, function (key, value) {
                                        if (value != "NULL") {
                                            assistants[key] = value;
                                        }
                                        else assistants[key] = "";
                                    });
                                    assistantsTd += '<a onclick="routie(\'assistants/' + assistants.userId + '\')">' + assistants.fname + ' ' + assistants.lname + '</a><br/>';
                                });
                                exercisesTd += '<tr><td><a onclick="routie(\'exercises/' + exercises.exerciseId + '\')">' + exercises.title + '</a></td><td>' + terms.laboratory.number + '</td><td><a onclick="routie(\'terms/' + terms.termId + '\')">' + terms.datetime + '</a></td><td>' + assistantsTd + '</td></tr>';
                            });
                        });

                        if (exercisesTd != "") {
                            $("#exercise-week").append('<tr><td class="bg-faded font-weight-bold">Subject</td><td colspan="3" class="bg-faded font-weight-bold"><a onclick="routie(\'subjects/' + subjects.subjectId + '\')">' + subjects.title + '</a></td></tr>' +
                                '<tr class="bg-faded font-weight-bold"><td>Exercise</td><td>Laboratory</td><td>Datetime</td><td>Assistants</td></tr>' + exercisesTd);
                        } else {
                            $("#exercise-week").append('<tr><td class="bg-faded font-weight-bold">Subject</td><td colspan="3" class="bg-faded font-weight-bold"><a onclick="routie(\'subjects/' + subjects.subjectId + '\')">' + subjects.title + '</a></td></tr>' +
                                '<tr class="bg-faded font-weight-bold"><td>Exercise</td><td>Laboratory</td><td>Datetime</td><td>Assistants</td></tr><tr><td colspan="4" style="text-align: center;">No Exercises and/or Terms</td></tr>');
                        }


                        var assistants = {};
                        var assistantsTd = "";
                        $.each(subjects.assistants, function (assistant, object) {
                            $.each(object, function (key, value) {
                                if (value != "NULL") {
                                    assistants[key] = value;
                                }
                                else assistants[key] = "";
                            });
                            assistantsTd += '<a onclick="routie(\'assistants/' + assistants.userId + '\')">' + assistants.fname + ' ' + assistants.lname + '</a><br/>';
                        });

                        $("#subject-all").append('<tr><td><a onclick="routie(\'subjects/' + subjects.subjectId + '\')">' + subjects.title + '</a></td><td>' + assistantsTd + '</td></tr>');
                    });
                }
                else {
                    $("#exercise-week").append('<tr><td style="text-align: center;">Exercises can not be loaded!</td></tr>');
                    $("#subject-all").append('<tr><td colspan="2" style="text-align: center;">Subjects can not be loaded!</td></tr>');
                }
            });
            $("html").getNiceScroll().resize();
        });
    };
})(jQuery);


/////home-subject/////

(function ($) {
    $.homeSubject = function (subjectId) {
        var form = "#home-subject";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=home-subject", {subjectId: subjectId}, function (response, status) {

                if (response != 0) {

                    var subjects = {};
                    $.each(response, function (subject, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                subjects[key] = value;
                            }
                            else subjects[key] = "";
                        });

                        $("#subject-title").text(subjects.title);

                        $("#subject-one").append('<tr><td class="font-weight-bold">Title</td><td>' + subjects.title + '</td></tr>');
                        $("#subject-one").append('<tr><td class="font-weight-bold">Description</td><td>' + subjects.description + '</td></tr>');

                        var departments = {};
                        var departmentsTd = "";
                        $.each(subjects.departments, function (department, object) {
                            $.each(object, function (key, value) {
                                if (value != "NULL") {
                                    departments[key] = value;
                                }
                                else departments[key] = "";
                            });
                            departmentsTd += departments.department.acronym + ' - ' + departments.department.title + '<br/>'
                        });

                        $("#subject-one").append('<tr><td class="font-weight-bold">Departments</td><td>' + departmentsTd + '</td></tr>');

                        var exercises = {};
                        $.each(subjects.exercises, function (exercise, object) {
                            $.each(object, function (key, value) {
                                if (value != "NULL") {
                                    exercises[key] = value;
                                }
                                else exercises[key] = "";
                            });
                            $("#subject-exercise").append('<tr><td><a onclick="routie(\'exercises/' + exercises.exerciseId + '\')">' + exercises.title + ' - ' + exercises.number + '</a></td></tr>');
                        });

                        if ($("#subject-exercise").children().length == 0) {
                            $("#subject-exercise").append('<tr><td style="text-align: center;">No Exercises</td></tr>');
                        }

                        var assistants = {};
                        $.each(subjects.assistants, function (assistant, object) {
                            $.each(object, function (key, value) {
                                if (value != "NULL") {
                                    assistants[key] = value;
                                }
                                else assistants[key] = "";
                            });
                            $("#subject-assistant").append('<tr><td><a onclick="routie(\'assistants/' + assistants.userId + '\')">' + assistants.fname + ' ' + assistants.lname + '</a></td></tr>');
                        });

                        if ($("#subject-assistant").children().length == 0) {
                            $("#subject-assistant").append('<tr><td style="text-align: center;">No Assistants</td></tr>');
                        }
                    });
                }
                else {
                    $("#subject-one").append('<tr><td style="text-align: center;">Subject can not be loaded!</td></tr>');
                    $("#subject-exercise").append('<tr><td style="text-align: center;">Exercises can not be loaded!</td></tr>');
                    $("#subject-assistant").append('<tr><td style="text-align: center;">Assistants can not be loaded!</td></tr>');
                }
            });
            $("html").getNiceScroll().resize();
        });
    };
})(jQuery);


/////home-еxercise/////

(function ($) {
    $.homeExercise = function (exerciseId) {
        var form = "#home-exercise";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=home-exercise", {exerciseId: exerciseId}, function (response, status) {

                if (response != 0) {

                    var exercises = {};
                    $.each(response, function (exercise, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                exercises[key] = value;
                            }
                            else exercises[key] = "";
                        });

                        $("#exercise-title").text(exercises.title);

                        $("#exercise-one").append('<tr><td class="font-weight-bold">Title</td><td>' + exercises.title + '</td></tr>');
                        $("#exercise-one").append('<tr><td class="font-weight-bold">Number</td><td>' + exercises.number + '</td></tr>');
                        $("#exercise-one").append('<tr><td class="font-weight-bold">Description</td><td>' + exercises.description + '</td></tr>');

                        var terms = {};
                        $.each(exercises.terms, function (term, object) {
                            $.each(object, function (key, value) {
                                if (value != "NULL") {
                                    terms[key] = value;
                                }
                                else terms[key] = "";
                            });
                            $("#exercise-term").append('<tr><td><a onclick="routie(\'terms/' + terms.termId + '\')">' + terms.datetime + ' - ' + terms.laboratory.number + '</a></td></tr>');
                        });

                        if ($("#exercise-term").children().length == 0) {
                            $("#exercise-term").append('<tr><td style="text-align: center;">No Terms</td></tr>');
                        }

                        var materials = {};
                        $.each(exercises.materials, function (material, object) {
                            $.each(object, function (key, value) {
                                if (value != "NULL") {
                                    materials[key] = value;
                                }
                                else materials[key] = "";
                            });
                            $("#exercise-material").append('<tr><td><i class="fa ' + materials.extension + '" aria-hidden="true"></i> <a onclick="$.homeMaterial(' + materials.materialId + ')">' + materials.title + '.' + materials.extension + '</a></td></tr>');
                        });

                        if ($("#exercise-material").children().length == 0) {
                            $("#exercise-material").append('<tr><td style="text-align: center;">No Materials</td></tr>');
                        }
                    });
                }
                else {
                    $("#exercise-one").append('<tr><td style="text-align: center;">Exercise can not be loaded!</td></tr>');
                    $("#exercise-term").append('<tr><td style="text-align: center;">Terms can not be loaded!</td></tr>');
                    $("#exercise-material").append('<tr><td style="text-align: center;">Materials can not be loaded!</td></tr>');
                }
            });
            $("html").getNiceScroll().resize();
        });
    };
})(jQuery);


/////home-term/////

(function ($) {
    $.homeTerm = function (termId) {
        var form = "#home-term";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=home-term", {termId: termId}, function (response, status) {

                if (response != 0) {

                    var terms = {};
                    $.each(response, function (term, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                terms[key] = value;
                            }
                            else terms[key] = "";
                        });

                        $("#term-name").text(terms.datetime + ' - ' + terms.laboratory.number);

                        $("#term-one").append('<tr><td class="bg-faded font-weight-bold">Datetime</td><td>' + terms.datetime + '</td> </tr>');
                        $("#term-one").append('<tr><td class="bg-faded font-weight-bold">Laboratory</td><td>' + terms.laboratory.number + '</a></td></tr>');

                        var assistants = {};
                        var assistantsTd = "";
                        $.each(terms.assistants, function (assistant, object) {
                            $.each(object, function (key, value) {
                                if (value != "NULL") {
                                    assistants[key] = value;
                                }
                                else assistants[key] = "";
                            });

                            assistantsTd += '<a onclick="routie(\'assistants/' + assistants.userId + '\')">' + assistants.fname + ' ' + assistants.lname + '</a></td><br/>';
                        });

                        $("#term-one").append('<tr><td class="bg-faded font-weight-bold">Assistants</td><td>' + assistantsTd + '</td></tr>');
                    });
                }
                else {
                    $("#term-one").append('<tr><td style="text-align: center;">Assistant can not be loaded!</td></tr>');
                }
            });
            $("html").getNiceScroll().resize();
        });
    };
})(jQuery);


/////home-material/////

(function ($) {
    $.homeMaterial = function (materialId) {
        var form = "#home-material";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $.getJSON("inc/ajax/ajax." + name + ".php?action=home-material", {materialId: materialId}, function (response, status) {

            if (response != 0) {

                var materials = {};
                $.each(response, function (material, object) {
                    $.each(object, function (key, value) {
                        if (value != "NULL") {
                            materials[key] = value;
                        }
                        else materials[key] = "";
                    });

                    window.open(materials.location.substr(6) + materials.file + '.' + materials.extension, '_blank');
                });
            }
        });
    };
})(jQuery);


/////home-assistant/////

(function ($) {
    $.homeAssistant = function (assistantId) {
        var form = "#home-assistant";
        var action = form.replace('#', '');
        var name = form.replace('#', '').replace(/-.*/, "");

        $("#page").load("inc/ajax/template/" + name + ".php?action=" + action, function () {

            $.getJSON("inc/ajax/ajax." + name + ".php?action=home-assistant", {assistantId: assistantId}, function (response, status) {

                if (response != 0) {

                    var assistants = {};
                    $.each(response, function (assistant, object) {
                        $.each(object, function (key, value) {
                            if (value != "NULL") {
                                assistants[key] = value;
                            }
                            else assistants[key] = "";
                        });

                        $("#assistant-name").text(assistants.fname + ' ' + assistants.lname);

                        $("#assistant-one").append('<tr><td class="bg-faded font-weight-bold">Name</td><td>' + assistants.fname + ' ' + assistants.lname + '</td> </tr>');
                        $("#assistant-one").append('<tr><td class="bg-faded font-weight-bold">E-Mail</td><td><a href="mailto:' + assistants.email + '">' + assistants.email + '</a></td></tr>');
                        $("#assistant-one").append('<tr><td class="bg-faded font-weight-bold">Description</td><td class="text-justify">' + assistants.description + '</td></tr>');
                    });
                }
                else {
                    $("#assistant-one").append('<tr><td style="text-align: center;">Assistant can not be loaded!</td></tr>');
                }
            });
            $("html").getNiceScroll().resize();
        });
    };
})(jQuery);

//homeMaterial