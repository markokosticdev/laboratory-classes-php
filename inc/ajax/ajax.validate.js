$(document).ready(function () {

    $.validator.setDefaults({
        errorClass: 'form-text text-danger',
        highlight: function (element) {
            $(element)
                .closest('.form-group')
                .addClass('has-danger');
        },
        unhighlight: function (element) {
            $(element)
                .closest('.form-group')
                .removeClass('has-danger');
        },
        errorPlacement: function (error, element) {
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});

$.validator.addMethod('strongPassword', function (value, element) {
    return this.optional(element)
        || value.length >= 6
        && /\d/.test(value)
        && /[a-z]/i.test(value);
}, "Your password must be at least 6 characters long and contain at least one number and one char'.");


$.validator.addMethod("validateUsername", function (value, element) {
    var valid = false;

    $.ajax({
        type: 'POST',
        url: "inc/ajax/ajax.validate.php?action=validate-username",
        data: {username: value},
        success: function (result) {
            if (result == 0) valid = true;
        },
        async: false
    });

    return valid;

}, "Your username exist in database");


$.validator.addMethod("validateSubjectTitle", function (value, element) {
    var valid = false;

    $.ajax({
        type: 'POST',
        url: "inc/ajax/ajax.validate.php?action=validate-subject-title",
        data: {title: value},
        success: function (result) {
            if (result == 0) valid = true;
        },
        async: false
    });

    return valid;

}, "Subject title exist in database");


$.validator.addMethod("validateExerciseTitle", function (value, element) {
    var valid = false;

    $.ajax({
        type: 'POST',
        url: "inc/ajax/ajax.validate.php?action=validate-exercise-title",
        data: {title: value},
        success: function (result) {
            if (result == 0) valid = true;
        },
        async: false
    });

    return valid;

}, "Еxercise title exist in database");


$.validator.addMethod("valueNotEquals", function (value, element, arg) {
    return arg != value;
}, "Value must not equal arg.");
