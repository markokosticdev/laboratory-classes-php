$(document).ready(function () {
    $("html").niceScroll({
        cursorcolor: "#373a3c",
        cursorwidth: "10px",
        cursorborder: "none",
        cursorborderradius: "0px",
        overflowx: false
    });

    $("#nav").load("inc/ajax/template/navigation.php", function () {

        $.post("inc/ajax/ajax.profile.php?action=profile-picture-load", function (response, status) {

            if (response != 0) {
                $(".profile-picture").attr("src", response);
            }
        });
    });

    //$.homeStart();
});


function confirmDialog(text) {
    return confirm(text);
}

(function ($) {
    $.fn.formAlert = function (style, message) {
        var alert = '<div class="row"> <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <div class="alert ' + style + '" role="alert">' + message + '</div> </div> </div>';
        $(this).prepend(alert);
        return this;
    };
})(jQuery);
