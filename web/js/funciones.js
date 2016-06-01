/**
 * Created by jorge on 5/9/16.
 */
$(document).ready(function(){
    
    /*Portada promocion*/
    var precio = $(".precioUnderline").html();
    var descuento = $(".descuentoPortada").html();
    var operacion = parseInt(precio)-parseInt(precio)*(parseInt(descuento)/100);
   
    $(".precioFinalPromocion").html(operacion+"&euro;");


    /*Pagina de novedad*/
    var descuento2;
    var precio2;
    var operar;
    var resultado;
    $(".nov-cont-desc").each(function(){
        descuento2 = $(this).find("span.descuentopromo").html();
        precio2 = $(this).find("span.preciopromo").html();
        operar = parseInt(precio2)-parseInt(precio2)*(parseInt(descuento2)/100);
        resultado = $(this).find("span.precioFinalPromocion2");
        $(resultado).html(operar+"€");
        //alert(operar);

    });
    
    
    /*Precio total del carrito*/
    var precioTotal = 0;
    $(".precio-producto-carrito").each(function () {
        precioTotal = parseInt(precioTotal)+parseInt($(this).html())
        //alert($(this).html());
    })
    $(".precio-lista").val(precioTotal)

    
    /*Imagen en miniaturas del producto*/
    var imagenCentral =  $(".imagenEspecificacion").html()
    $(".imagenEspecificacionMin").each(function () {

        /*$(this).mousemove(function () {
            $(".imagenEspecificacion").html($(this).html());
        });*/
        /*$(this).mouseout(function () {
            $(".imagenEspecificacion").html(imagenCentral);
        });*/

        $(this).click(function () {
            $(".imagenEspecificacion").html($(this).html());
        });
    });
});


