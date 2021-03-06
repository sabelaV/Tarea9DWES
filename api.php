<?php
include "bd.php";
?>
<?php
// Esta API tiene dos posibilidades; Mostrar una lista de autores o mostrar la información de un autor específico.


function get_lista_autores(){
    //Esta información se carga de la base de datos
$conexion_tequila = new gestionLibros();
$hablandobd = $conexion_tequila->conexion("sql211.byethost15.com", "b15_27766104", "s793g1r5", "b15_27766104_libros");
//$hablandobd = $conexion_tequila->conexion("localhost", "sabela", "lisa07", "libros");
if (!$hablandobd){
  echo "Error estableciendo la conexión";
  
}

else{

  //echo "Conexión establecida<br>";
  $lista_autores = $conexion_tequila->consultarAutores($hablandobd);
  
  if (is_null($lista_autores))
  {
    echo "Error al leer autor";

  }
  else
  {  
    return $lista_autores;}
  }
}

function get_datos_autor($id){
    $info_autor = array();
    //Esta información se carga de la base de datos
$conexion_tequila = new gestionLibros();
$hablandobd = $conexion_tequila->conexion("sql211.byethost15.com", "b15_27766104", "s793g1r5", "b15_27766104_libros");
//$hablandobd = $conexion_tequila->conexion("localhost", "sabela", "lisa07", "libros");
if (!$hablandobd){
  echo "Error estableciendo la conexión";
  
}

else{

  //echo "Conexión establecida<br>";
  $info_autor["datos_autor"] = $conexion_tequila->consultarAutoresid($hablandobd, $id);
  var_dump($info_autor["datos_autor"]); echo "<br>";
  $info_autor["libros"] = $conexion_tequila->consultarLibros($hablandobd, $id);
   $json = json_encode($info_autor);
  }
  if (is_null($json))
  {
    echo "Error al leer autor";

  }
  else
  { 
    return $json;}
  }
/**
*Función que recupera de la base de datos los autores
*cuyo apellido contiene los caracteres buscados
*y los libros escritos por dichos autores
*@author Sabela Vila
*version 1
*@since tarea9
*@param string $caracteres
*@return json todos_autores (lista de autores y sus libros)
*/
function get_datos_autoresApellido($caracteres){
/**
*Función que nos permite hacer array_push en array asociativo
*
*/
function array_push_assoc(array &$arrayDatos, array $values){
        $arrayDatos = array_merge($arrayDatos, $values);
    }

    $autores = array();
    $todos_autores = array();
//Conexión a la base de datos
$conexion_tequila = new gestionLibros();
$hablandobd = $conexion_tequila->conexion("sql211.byethost15.com", "b15_27766104", "s793g1r5", "b15_27766104_libros");
//$hablandobd = $conexion_tequila->conexion("localhost", "sabela", "lisa07", "libros");
if (!$hablandobd){
  echo "Error estableciendo la conexión";
  
}

else{

  //Se consultan los datos de autores cuyo apellido contenga los caracteres pasados por parámetro

  $lista_autores = $conexion_tequila->consultarAutoresApellido($hablandobd, $caracteres);

    foreach ($lista_autores as $autor){
      //Se consultan los datos de los libros escritos por el autor
      $lista_libros = $conexion_tequila->consultarLibros($hablandobd, $autor["id"]);
      array_push_assoc($autores, array('id'=>$autor["id"]));
      array_push_assoc($autores, array('nombre'=>$autor["nombre"]));
      array_push_assoc($autores, array('apellidos'=>$autor["apellidos"]));
      array_push_assoc($autores, array('libros'=>$lista_libros));
      array_push($todos_autores, $autores);
    }   
}
  if (is_null($todos_autores))
  {
    echo "Error al leer autor";

  }
  else
  { 
    return $todos_autores;}
  }

function get_lista_libros(){
    //Esta información se carga de la base de datos
$conexion_tequila = new gestionLibros();
$hablandobd = $conexion_tequila->conexion("sql211.byethost15.com", "b15_27766104", "s793g1r5", "b15_27766104_libros");
//$hablandobd = $conexion_tequila->conexion("localhost", "sabela", "lisa07", "libros");
if (!$hablandobd){
  echo "Error estableciendo la conexión";
  
}

else{

  //echo "Conexión establecida<br>";
  $lista_libros = $conexion_tequila->Libros($hablandobd);
  
  if (is_null($lista_libros))
  {
    echo "Error al leer libros";

  }
  else
  {

  
    return $lista_libros;}
  }
}

function get_datos_libro($id){
    $info_autor = array();
    //Esta información se carga de la base de datos
$conexion_tequila = new gestionLibros();
$hablandobd = $conexion_tequila->conexion("sql211.byethost15.com", "b15_27766104", "s793g1r5", "b15_27766104_libros");
//$hablandobd = $conexion_tequila->conexion("localhost", "sabela", "lisa07", "libros");
if (!$hablandobd){
  echo "Error estableciendo la conexión";
  
}

else{

  //echo "Conexión establecida<br>";
  $datos_libro = $conexion_tequila->conseguirDatosLibro($hablandobd, $id);
   
  }
  if (is_null($datos_libro))
  {
    echo "Error al leer autor";

  }
  else
  { 
    return $datos_libro;}
  }

$posibles_URL = array("get_lista_autores", "get_datos_autor", "get_lista_libros", "get_datos_libro", "get_datos_autoresApellido");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL))
{
  switch ($_GET["action"])
    {
      case "get_lista_autores":
        $valor = get_lista_autores();
        break;
      case "get_datos_autor":
        if (isset($_GET["id"]))
            $valor = get_datos_autor($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
	  break;
    case "get_datos_libro":
        if (isset($_GET["id"]))
            $valor = get_datos_libro($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
    break;
	  case "get_lista_libros":
			$valor = get_lista_libros();
      break;
      case "get_datos_autoresApellido":
        if (isset($_GET["caracteres"]))
            $valor = get_datos_autoresApellido($_GET["caracteres"]);
        else
            $valor = "Argumento no encontrado";
    break;
    }
}

//devolvemos los datos serializados en JSON
exit(json_encode($valor));
?>