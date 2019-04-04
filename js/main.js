$(document).ready(function() {
    //Vertically center stuff
    $(".topnav").css("padding-top", parseFloat($(".topnav").css("height")) / 2 - parseFloat($(".topnav a").css("line-height")) / 2);
    $("#createRoom a").css("padding-top", parseFloat($("#createRoom").css("height")) / 2 - parseFloat($("#createRoom").css("line-height")) / 2);
    $("#createRoom a").css("padding-bottom", parseFloat($("#createRoom").css("height")) / 2 - parseFloat($("#createRoom").css("line-height")) / 2);
    $("#joinRoom a").css("padding-top", parseFloat($("#joinRoom").css("height")) / 2 - parseFloat($("#joinRoom").css("line-height")) / 2);
    $("#joinRoom a").css("padding-bottom", parseFloat($("#joinRoom").css("height")) / 2 - parseFloat($("#joinRoom").css("line-height")) / 2);
    $("#startGame a").css("padding-top", parseFloat($("#startGame").css("height")) / 2 - parseFloat($("#startGame").css("line-height")) / 2);
    $("#startGame a").css("padding-bottom", parseFloat($("#startGame").css("height")) / 2 - parseFloat($("#startGame").css("line-height")) / 2);

    //Change colors when hovering over topnav links
    $(".topnav a").on({
        mouseenter: function() {
            $(this).css("color", "white");
        },
        mouseleave: function() {
            $(this).css("color", "rgb(187, 187, 187)");
        },
    });

    //Change size when hovering room choices
    $("#createRoom a").on({
        mouseenter: function() {
            $(this).css("font-size", "75px");
        },
        mouseleave: function() {
            $(this).css("font-size", "50px");
        },
    });
    $("#joinRoom a").on({
        mouseenter: function() {
            $(this).css("font-size", "75px");
        },
        mouseleave: function() {
            $(this).css("font-size", "50px");
        },
    });
    $("#startGame a").on({
        mouseenter: function() {
            $(this).css("font-size", "75px");
        },
        mouseleave: function() {
            $(this).css("font-size", "50px");
        },
    });
});