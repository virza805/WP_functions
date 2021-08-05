jQuery(document).ready(function (e) {
    function t(t) {
        e(t).bind("click", function (t) {
            t.preventDefault();
            e(this).parent().fadeOut()
        })
    }
    e(".dropdown-toggle").click(function () {
        var t = e(this).parents(".menu_sub").children(".dropdown-menu").is(":hidden");
        e(".menu_sub .dropdown-menu").hide();
        e(".menu_sub .dropdown-toggle").removeClass("active");
        if (t) {
            e(this).parents(".menu_sub").children(".dropdown-menu").toggle().parents(".menu_sub").children(".dropdown-toggle").addClass("active")
        }
    });
    e(document).bind("click", function (t) {
        var n = e(t.target);
        if (!n.parents().hasClass("menu_sub")) e(".menu_sub .dropdown-menu").hide();
    });
    e(document).bind("click", function (t) {
        var n = e(t.target);
        if (!n.parents().hasClass("menu_sub")) e(".menu_sub .dropdown-toggle").removeClass("active");
    })
});