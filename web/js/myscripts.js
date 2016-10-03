$(function(){

    $(".infoTop").click(function(){
        $("div").removeClass("outline");
        $("span").removeClass("rotateIcon");
        $(".show").removeClass("show");
        $(this).parent().toggleClass("outline");
        // $(this).children(".glyphicon").toggleClass("rotateIcon");
    });

    $(".accordian").click(function(){
        $(this).next().toggleClass("show");
        $(this).children(".glyphicon").toggleClass("rotateIcon");

    });
});
