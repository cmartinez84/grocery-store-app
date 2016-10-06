$(function(){

    $(".accordian").click(function(){
        $(this).next().toggleClass("show");
        // alert("ouch");
        // $(this).children(".glyphicon").toggleClass("rotateIcon");
    });

    $(".confirmationRollUp").click(function(){

        $(".logIn").toggleClass("hide");
        $(".confirmation").toggleClass("hide");
        $(this).hide();
    });

    $(".accordianSignUp").click(function(){
        $(".signUp").toggleClass("hide");
        $(".logIn").toggleClass("hide");
        $(this).hide();
    });

    $(".verifyAddress").click(function(){
        $(".checkAddress").removeClass("hide");
    })
    $(".pickup").click(function(){
        $(".checkAddress").addClass("hide");
    })



});
