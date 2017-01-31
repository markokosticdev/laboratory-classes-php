$(document).ready(function () {

    routie({

        '': function () {
            $.homeStart();
        },
        'home': function () {
            $.homeStart();
        },
        'assistants/add': function () {
            $.assistantAdd();
        },
        'assistants/edit': function () {
            $.assistantEdit();
        },
        'assistants/delete': function () {
            $.assistantDelete();
        },
        'assistants/:assistantId': function (assistantId) {
            $.homeAssistant(assistantId);
        },
        'subjects/add': function () {
            $.subjectAdd();
        },
        'subjects/edit': function () {
            $.subjectEdit();
        },
        'subjects/delete': function () {
            $.subjectDelete();
        },
        'subjects/:subjectId': function (subjectId) {
            $.homeSubject(subjectId);
        },
        'exercises/add': function () {
            $.exerciseAdd();
        },
        'exercises/edit': function () {
            $.exerciseEdit();
        },
        'exercises/delete': function () {
            $.exerciseDelete();
        },
        'exercises/:exerciseId': function (exerciseId) {
            $.homeExercise(exerciseId);
        },
        'terms/add': function () {
            $.termAdd();
        },
        'terms/edit': function () {
            $.termEdit();
        },
        'terms/delete': function () {
            $.termDelete();
        },
        'terms/:termId': function (termId) {
            $.homeTerm(termId);
        },
        'profile/edit': function () {
            $.profileEdit();
        }

    });
});


