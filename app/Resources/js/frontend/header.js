
$(document).ready(function() {
    $(window).on('scroll', function () {
        if (window.pageYOffset > 100) {
            $('#mainNav').addClass("nav-fix");
        } else {
            $('#mainNav').removeClass("nav-fix");
        }
    });
});

