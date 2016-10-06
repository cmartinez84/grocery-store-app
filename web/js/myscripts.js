$(function(){



    $(".accordian").click(function(){
        $(this).next().toggleClass("show");
        // alert("ouch");
        // $(this).children(".glyphicon").toggleClass("rotateIcon");
    });
    $(".accordian-roll-up").click(function(){
        $(this).prev().toggleClass("hide");
        // alert("ouch");
        // $(this).children(".glyphicon").toggleClass("rotateIcon");
    });

});
