$(function () {
    var show = true;
    $(window).scroll(function () {
        var y = document.documentElement.scrollTop + document.body.scrollTop;
        if (show && y > 200) {
            $("#gotop").fadeIn(500);
        } else {
            $("#gotop").fadeOut(500);
        }
    });
    $("#gotop").click(function () {
        show = false;
        $("html,body").animate({scrollTop: "0px"}, 500, function () {
            show = true;
        });
    });
});