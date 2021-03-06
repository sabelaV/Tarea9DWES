<html>
 <body>

<?php
// Si se ha hecho una peticion que busca informacion de un autor "get_datos_autor" a traves de su "id"...
//******************************************************************************************************************************************
if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_autor") 
{
    //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
    $app_info = file_get_contents('http://instintoweb.byethost15.com/api.php?action=get_datos_autor&id=' . $_GET["id"]);
    // Se decodifica el fichero JSON y se convierte a array
    $app_info = json_decode($app_info, true);
?>
    <table>
        <tr>
            <td>Nombre: </td><td> <?php echo $app_info["datos_autor"]["nombre"] ?></td>
        </tr>
        <tr>
            <td>Apellidos: </td><td> <?php echo $app_info["datos_autor"]["apellidos"] ?></td>
        </tr>
        <tr>
            <td>Fecha de nacimiento: </td><td> <?php echo $app_info["datos_autor"]["nacionalidad"] ?></td>
        </tr>
    </table>
	
	<!-- Listado de libros del autor -->
	<ul>
    <?php foreach($app_info["libros"] as $libro): ?>
        <li>
            <!-- Enlazamos cada libro con sus datos -->
            <a href="<?php echo "http://instintoweb.byethost15.com/cliente.php?action=get_datos_libro&id=" . $libro["id"]  ?>">
            <?php echo $libro["titulo"] ?>
            </a>
        </li>
    <?php endforeach; ?>
	</ul>
	
    <br />
    <!-- Enlace para volver a la lista de autores -->
    <a href="http://instintoweb.byethost15.com/cliente.php?action=get_lista_autores" alt="Lista de autores">Volver a la lista de autores</a>
<?php
}
//*******************************************************************************************************************************************
//AQUÍ pongo la nueva acción que llama a la función: function get_datos_autoresApellido($caracteres) 
//*******************************************************************************************************************************************
if (isset($_GET["action"]) && isset($_GET["caracteres"]) && $_GET["action"] == "get_datos_autoresApellido") 
{
    //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores cuyos caracteres
    //aparezcan en el apellido y sus libros correspondientes
    //$app_info = file_get_contents('http://instintoweb.byethost15.com/api.php?action=get_datos_autor&id=' . $_GET["id"]);
    $app_info = file_get_contents('http://instintoweb.byethost15.com/api.php?action=get_datos_autoresApellido&caracteres=' . $_GET["caracteres"]);
    //http://localhost/dwes/T7byehost/api.php?action=get_datos_autoresApellido&caracteres=a
    // Se decodifica el fichero JSON y se convierte a array
    $app_info = json_decode($app_info, true);
    $i =0;
    //Se formatean los datos en html
?>
    <ul>
    <?php foreach($app_info as $autor): ?>
        <li style ="list-style-type : none">
            <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
            <?php echo $app_info[$i]["nombre"] . "&nbsp" . $app_info[$i]["apellidos"]; ?>
        </li>
        <li style ="list-style-type : none">

            <ul>
                <!-- Listado de libros del autor -->
                <?php $j=0;  foreach($app_info[$i]["libros"] as $libro): ?>
                    <li>
                       <?php echo $app_info[$i]["libros"][$j]["titulo"]; $j++; ?>
                    </li>
               <?php endforeach; $i++; echo "<br>";?> 
            </ul>
        </li>
    <?php endforeach; ?>
    </ul>
    
    

<?php
}
//*******************************************************************************************************************************************
else if (isset($_GET["action"]) && $_GET["action"] == "get_lista_libros")
{
    // Pedimos al la api que nos devuelva una lista de autores. La respuesta se da en formato JSON
    $lista_libros = file_get_contents('http://instintoweb.byethost15.com/api.php?action=get_lista_libros');
    // Convertimos el fichero JSON en array
	var_dump($lista_libros);
    $lista_libros = json_decode($lista_libros, true);
?>
    <ul>
    <!-- Mostramos una entrada por cada autor -->
    <?php foreach($lista_libros as $libro): ?>
        <li>
            <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
            <a href="<?php echo "http://instintoweb.byethost15.com/cliente.php?action=get_datos_libro&id=" . $libro["id"]  ?>">
            <?php echo $libro["titulo"] ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
  <?php
}  
//*******************************************************************************************************************************************
// Si se ha hecho una peticion que busca informacion de un autor "get_datos_autor" a traves de su "id"...
else if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_libro") 
{
    //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
    $app_info = file_get_contents('http://instintoweb.byethost15.com/api.php?action=get_datos_libro&id=' . $_GET["id"]);
    // Se decodifica el fichero JSON y se convierte a array
    $app_info = json_decode($app_info, true);
?>
    <table>
        <tr>
            <td>Título: </td><td> <?php echo $app_info["titulo"] ?></td>
        </tr>
        <tr>
            <td>Fecha de publicación: </td><td> <?php echo $app_info["f_publicacion"] ?></td>
        </tr>
        <tr>
            <td>Nombre del autor: </td><td> <a href="<?php echo "http://instintoweb.byethost15.com/cliente.php?action=get_datos_autor&id=" . $app_info["id"]  ?>"> <?php echo $app_info["nombre"] ?></a> </td>
        </tr>
         <tr>
            <td>Apellidos del autor: </td><td> <?php echo $app_info["apellidos"] ?></td>
        </tr>
    </table>  
    <br />
    <!-- Enlace para volver a la lista de autores -->
    <a href="http://instintoweb.byethost15.com/cliente.php?action=get_lista_libros" alt="Lista de libros">Volver a la lista de libros</a>
<?php
}
//*******************************************************************************************************************************************
else //sino muestra la lista de autores
{
    // Pedimos al la api que nos devuelva una lista de autores. La respuesta se da en formato JSON
    $lista_autores = file_get_contents('http://instintoweb.byethost15.com/api.php?action=get_lista_autores');
    // Convertimos el fichero JSON en array
	var_dump($lista_autores);
    $lista_autores = json_decode($lista_autores, true);
?>
    <ul>
    <!-- Mostramos una entrada por cada autor -->
    <?php foreach($lista_autores as $autores): ?>
        <li>
            <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
            <a href="<?php echo "http://instintoweb.byethost15.com/cliente.php?action=get_datos_autor&id=" . $autores["id"]  ?>">
            <?php echo $autores["nombre"] . " " . $autores["apellidos"] ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
  <?php
} ?>
 </body>
</html>