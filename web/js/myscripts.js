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

<a href="javascript:deleteProduct({$product->id})">Delete Product</a>

function deleteProduct(id) {
    $.ajax({
        type:'DELETE',
        url:'/cart/delete/'+id,
        success:function(html) {
            $('#cart').html(html);
        }
    });
}
/*function updateProduct() {
    $.ajax({
        type:'PATCH',
        url:'/cart/edit',
        success:function(html) {
            $('#cart').html(html);
        }
    });
}*/
