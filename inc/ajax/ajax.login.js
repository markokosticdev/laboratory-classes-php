$(document).ready(function () {

    $("body").on("click touchstart", "#login", function () {

        var username = $("#username").val();
        var password = $("#password").val();

        $.post("inc/ajax/ajax.login.php", {username: username, password: password}, function (response, status) {

            if (response == 1 || response == 2 || response == 3) {
                $("#nav").load("inc/ajax/template/navigation.php", function () {

                    $.post("inc/ajax/ajax.profile.php?action=profile-picture-load", function (response, status) {

                        if (response != 0) {
                            $(".profile-picture").attr("src", response);
                        }
                    });
                });
            }
            else if (response == 0) {
                $("#login-form").addClass("has-danger");
            }
        });
    }).on("keyup", "#login-form", function (event) {
        if (event.keyCode == 13) {
            if ($("#username,#password").is(":focus")) {

                $("#login").trigger("click");
            }
        }
    });
});