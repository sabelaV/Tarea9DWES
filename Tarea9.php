<!DOCTYPE html>
<html>
<!-- Versión 1.0 -->
<head>
<script src="jquery-3.5.1.min.js"></script>

<script>
$(document).ready(function(){
    $("#texto").keyup(function(){
        //$("#sugerencias").load("cargarLibros.php?q=" + $("#texto").val());
        $("#sugerencias").load("cliente.php?action=get_datos_autoresApellido&caracteres=" + $("#texto").val());
        //eL MÉTODO AJAX más sencillo ofrecido por jQuery es load(),
        //que se encarga de cargar un archivo html, php, txt, etc.
        //en un elemento específico de una página de manera asíncrona
        //no requiere realizar los pasos vistos con el objeto XMLHttpRequest
        //localhost/dwes/T7byehost/api.php?action=get_datos_autoresApellido&caracteres=a
    });
});
</script> 
</head>
<body>
<p><b>Búsqueda de libros:</b></p>
<form> 
<!--
    Cada vez que tecleamos algo en este field se ejecutará mostrar_sugerencias 
-->
Título: <input type="text" id="texto" >
</form>
<!-- En el span con id="sugerencias" mostraremos las coincidencias -->
<p><strong>Sugerencias:</strong> <span id="sugerencias" style="color: #0080FF;"></span></p>
</body> 
</html>
