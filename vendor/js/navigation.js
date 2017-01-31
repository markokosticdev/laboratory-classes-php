$(document).ready(function () {

    $("body").on("click touchstart", "#home-start-link", function () {
        //$.homeStart();
        routie('');

    }).on("click touchstart", "#assistant-add-link", function () {
        //$.assistantAdd();
        routie('assistants/add');

    }).on("click touchstart", "#assistant-edit-link", function () {
        //$.assistantEdit();
        routie('assistants/edit');

    }).on("click touchstart", "#assistant-delete-link", function () {
        //$.assistantDelete();
        routie('assistants/delete');

    }).on("click touchstart", "#subject-add-link", function () {
        //$.subjectAdd();
        routie('subjects/add');

    }).on("click touchstart", "#subject-edit-link", function () {
        //$.subjectEdit();
        routie('subjects/edit');

    }).on("click touchstart", "#subject-delete-link", function () {
        //$.subjectDelete();
        routie('subjects/delete');

    }).on("click touchstart", "#exercise-add-link", function () {
        //$.exerciseAdd();
        routie('exercises/add');

    }).on("click touchstart", "#exercise-edit-link", function () {
        //$.exerciseEdit();
        routie('exercises/edit');

    }).on("click touchstart", "#exercise-delete-link", function () {
        //$.exerciseDelete();
        routie('exercises/delete');

    }).on("click touchstart", "#term-add-link", function () {
        //$.termAdd();
        routie('terms/add');

    }).on("click touchstart", "#term-edit-link", function () {
        //$.termEdit();
        routie('terms/edit');

    }).on("click touchstart", "#term-delete-link", function () {
        //$.termDelete();
        routie('terms/delete');

    }).on("click touchstart", "#profile-link", function () {
        //$.profileEdit();
        routie('profile/edit');

    });
});



















