$(document).ready(function () {
    $("body").on("click touchstart", "#logout", function () {

        $.post("inc/ajax/ajax.logout.php", function (response, status) {

            if (response == 0) {
                $("#nav").load("inc/ajax/template/navigation.php", function () {

                    $("#profile-link").attr("src", "res/img/profile.png");

                });
                $.homeStart();
            }
        });
    })
});