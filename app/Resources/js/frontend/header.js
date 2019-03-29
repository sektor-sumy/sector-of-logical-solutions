
$(document).ready(function() {
    $(window).on('scroll', function () {
        if (window.pageYOffset > 100) {
            $('#mainNav').addClass("nav-fix");
        } else {
            $('#mainNav').removeClass("nav-fix");
        }
    });

    $(function(){
        $('.selectpicker').selectpicker();
    });

    // $("#switchLang").on('scroll', function () {
    //     // var display = $('#switchLangList');
    //
    //     console.log(1);
    //     // if (window.pageYOffset > 100) {
    //     //     $('#mainNav').addClass("nav-fix");
    //     // } else {
    //     //     $('#mainNav').removeClass("nav-fix");
    //     // }
    // });
});

