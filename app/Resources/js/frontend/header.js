
$(document).ready(function() {

    $(window).on('scroll', function () {
        var scrolled = window.pageYOffset;


        if (window.pageYOffset > 100) {
            $('#mainNav').addClass("nav-fix");
        } else {
            $('#mainNav').removeClass("nav-fix");
        }
    });

});
