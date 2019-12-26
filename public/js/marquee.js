/*
https://jsfiddle.net/MadLittleMods/nsMWX/
 */
// for stuff that scrolls left on hover
$(".scroll_on_hover").mouseover(function () {
    $(this).removeClass("ellipsis");
    var maxscroll = 2000;
    var speed = maxscroll * 15;
    $(this).animate({
        scrollLeft: maxscroll
    }, speed, "linear");
});

$(".scroll_on_hover").mouseout(function () {
    $(this).stop();
    $(this).addClass("ellipsis");
    $(this).animate({
        scrollLeft: 0
    }, 'slow');
});
