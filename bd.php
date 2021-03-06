<?php
class gestionLibros{

	 public function __construct(){
       
    }
	public function conexion($servidor, $usuario, $contraseña, $bd)
	{
		@$mysqli = new mysqli($servidor, $usuario, $contraseña, $bd);
		if ($mysqli->connect_errno)
		{
		return null;
		}
		else
		{
		$mysqli->set_charset("utf8");
		return $mysqli;
		}
	}

	public function consultarLibros($mysqli, $id)
	{
		$sql = "SELECT * FROM libro where id_autor='$id'";

		$resultset = $mysqli->query($sql);
		if ($resultset->num_rows > 0 && !$mysqli->error)
		{
		$resultado = $resultset->fetch_all(MYSQLI_ASSOC);
		return $resultado;
		}
		else
		{
		return null;
		}
	}

	public function consultarAutores($mysqli)
	{
		$sql = "SELECT * FROM autor";

		$resultset = $mysqli->query($sql);
		if ($resultset->num_rows > 0 && !$mysqli->error)
		{
		$resultado = $resultset->fetch_all(MYSQLI_ASSOC);
		return $resultado;
		}
		else
		{
		return null;
		}
	}

	public function consultarAutoresid($mysqli, $id)
	{
		$sql = "SELECT * FROM autor where id='$id'";

		$resultset = $mysqli->query($sql);
		if ($resultset->num_rows > 0 && !$mysqli->error)
		{
		$resultado = $resultset->fetch_object();
		return $resultado;
		}
		else
		{
		return null;
		}
	}

	public function consultarAutoresApellido($mysqli, $caracteres)
	{
		$sql = "SELECT * FROM autor where apellidos LIKE '%$caracteres%'";

		$resultset = $mysqli->query($sql);
		if ($resultset->num_rows > 0 && !$mysqli->error)
		{
		$resultado = $resultset->fetch_all(MYSQLI_ASSOC);
		return $resultado;
		}
		else
		{
		return null;
		}
	}

	public function Libros($mysqli)
	{
		$sql = "SELECT * FROM libro";

		$resultset = $mysqli->query($sql);
		if ($resultset->num_rows > 0 && !$mysqli->error)
		{
		$resultado = $resultset->fetch_all(MYSQLI_ASSOC);
		return $resultado;
		}
		else
		{
		return null;
		}
	}

	public function consultarDatosLibro($mysqli, $id)
	{
		$sql = "SELECT * FROM libro where id='$id'";

		$resultset = $mysqli->query($sql);
		if ($resultset->num_rows > 0 && !$mysqli->error)
		{
		$resultado = $resultset->fetch_object();
		return $resultado;
		}
		else
		{
		return null;
		}
	}

	public function conseguirDatosLibro($mysqli, $id)
	{
		$sql = "SELECT libro.titulo, libro.f_publicacion, autor.id, autor.nombre, autor.apellidos FROM libro INNER JOIN autor ON libro.id_autor = autor.id WHERE libro.id ='$id'";
		$resultset = $mysqli->query($sql);
		if ($resultset->num_rows > 0 && !$mysqli->error)
		{
		$resultado = $resultset->fetch_object();
		return $resultado;
		}
		else
		{
		return null;
		}
	}

//SELECT libro.titulo, libro.f_publicacion, autor.nombre, autor.apellidos FROM libro INNER JOIN autor ON libro.id_autor = autor.id WHERE libro.id_autor = 1;
	public function actualizar($mysqli, $sql){    
		$mysqli->query($sql);
        if ($mysqli->error)
		{
			return "Error al actualizar libros: " . $mysqli->error;			
		}
		else
		{
			if ($mysqli->affected_rows == 0)
				return "No se ha actualizado ningún libro";
			else 
				return "Libro actualizado";			
		}      
    } 

	public function actualizarLibro($mysqli, $campos, $condicion){ 
		$sql = "UPDATE libro 
		SET $campos 
		WHERE $condicion";   
		$mysqli->query($sql);
        if ($mysqli->error)
		{
			return "Error al actualizar libros: " . $mysqli->error;			
		}
		else
		{
			if ($mysqli->affected_rows == 0)
				return "No se ha actualizado ningún libro";
			else 
				return "Libro actualizado";			
		}      
    } 

    public function actualizarAutor($mysqli, $campos, $condicion){ 
		$sql = "UPDATE libro 
		SET $campos 
		WHERE $condicion";   
		$mysqli->query($sql);
        if ($mysqli->error)
		{
			return "Error al actualizar autor: " . $mysqli->error;			
		}
		else
		{
			if ($mysqli->affected_rows == 0)
				return "No se ha actualizado ningún autor";
			else 
				return "Autor actualizado";			
		}      
    } 
    public function borrarAutor($mysqli, $id){   
    	$sql = "DELETE FROM autor 
		WHERE id = '$id'";  
		$mysqli->query($sql);
        if ($mysqli->error)
		{
			return "Error al borrar autor: " . $mysqli->error;			
		}
		else
		{
			if ($mysqli->affected_rows == 0)
				return "No se ha borrado ningún autor";
			else 
				return "autor borrado";			
		}      
    } 
    public function borrarLibro($mysqli, $id){  
    	$sql = "DELETE FROM libro  
		WHERE id='$id'";  
		$mysqli->query($sql);
        if ($mysqli->error)
		{
			return "Error al borrar libro: " . $mysqli->error;			
		}
		else
		{
			if ($mysqli->affected_rows == 0)
				return "No se ha borrado ningún libro";
			else 
				return "Libro borrado";			
		}      
    } 
    public function borrar($mysqli, $sql){    
		$mysqli->query($sql);
        if ($mysqli->error)
		{
			return "Error al borrar libros: " . $mysqli->error;			
		}
		else
		{
			if ($mysqli->affected_rows == 0)
				return "No se ha borrado ningún libro";
			else 
				return "Libro borrado";			
		}      
    } 

	public function borrarAutorySusLibros($mysqli, $id){   
    		function borrar1($mysqli, $sql, &$error){
			$mysqli->query($sql);
			echo $sql;
			if ($mysqli->error)
			{
				$error = "Error al borrar: " . $mysqli->error;
				
				if ($mysqli->affected_rows == 0)
					$error = "No se ha borrado ningún registro";
			}
			else $error = "";
			
			return ($error == "");
			}
		
		/* Deshabilitar autocommit */
		$mysqli->autocommit(FALSE);

		$mysqli->begin_transaction();

		$error = "";

		$sql1 = "DELETE FROM autor 
		WHERE id = '$id'";
		$sql2 = "DELETE FROM libro  
		WHERE id_autor='$id'";

		$all_query_ok = borrar1($mysqli, $sql1, $error)
		&& borrar1 ($mysqli, $sql2 , $error);

		/* Comprobamos si las operaciones han salido bien o mal para confirmar o revertir la transacción */
		if ($all_query_ok)
		{
			echo "OK, commit";
			$mysqli->commit();
		}
		else
		{
			echo "Error, rollback; " . $error;
			$mysqli->rollback(); 
		}

		/* Activar nuevamente autocommit */
		$mysqli->autocommit(TRUE);

    } 

    public function reiniciar($mysqli){
		
		
		function insertar($mysqli, $id, $nombre, $apellidos, $nacionalidad, &$error){
			$sql = "INSERT INTO autor (id, nombre, apellidos, nacionalidad) VALUES ('$id', '$nombre', '$apellidos', '$nacionalidad')";
			$mysqli->query($sql);
			echo $sql;
			if ($mysqli->error)
			{
				$error = "Error al actualizar autores: " . $mysqli->error;
				
				if ($mysqli->affected_rows == 0)
					$error = "No se ha actualizado ningún registro";
			}
			else $error = "";
			
			return ($error == "");
		}

		function insertarLibro($mysqli, $id, $titulo, $f_publicacion, $id_autor, &$error){
			$sql = "INSERT INTO libro (id, titulo, f_publicacion, id_autor) VALUES ('$id', '$titulo', '$f_publicacion', '$id_autor')";
			$mysqli->query($sql);
			echo $sql;
			if ($mysqli->error)
			{
				$error = "Error al actualizar libros: " . $mysqli->error;
				
				if ($mysqli->affected_rows == 0)
					$error = "No se ha actualizado ningún registro";
			}
			else $error = "";
			
			return ($error == "");
		}

		
		function borrar2($mysqli, $tabla, &$error){
			$sql = "DELETE FROM $tabla";
			$mysqli->query($sql);
			echo $sql;
			if ($mysqli->error)
			{
				$error = "Error al borrar: " . $mysqli->error;
				
				if ($mysqli->affected_rows == 0)
					$error = "No se ha borrado ningún registro";
			}
			else $error = "";
			
			return ($error == "");
		}

		/* Deshabilitar autocommit */
		$mysqli->autocommit(FALSE);

		$mysqli->begin_transaction();

		$error = "";

		$all_query_ok = borrar2($mysqli, 'autor', $error)
		&& borrar2 ($mysqli, 'libro', $error)
		&& insertar($mysqli, '0', 'J.R.R.', 'Tolkien', 'Inglaterra', $error)
		&& insertar($mysqli, '1', 'Isaac', 'Asimov', 'Rusia', $error)
		&& insertarLibro($mysqli, '0', 'El Hobbit', '21/09/1937', '0', $error)
		&& insertarLibro($mysqli, '1', 'La Comunidad del Anillo', '29/07/1954', '0', $error)
		&& insertarLibro($mysqli, '2', 'Las Dos Torres', '11/11/1954', '0', $error)
		&& insertarLibro($mysqli, '3', 'El Retorno del Rey', '20/10/1995', '0', $error)
		&& insertarLibro($mysqli, '4', 'Un Guijarro en el Cielo', '19/01/1950', '1', $error)
		&& insertarLibro($mysqli, '5', 'Fundación', '01/06/1951', '1', $error)
		&& insertarLibro($mysqli, '6', 'Yo, robot', '02/12/1950', '1', $error);

		
		/* Comprobamos si las operaciones han salido bien o mal para confirmar o revertir la transacción */
		if ($all_query_ok)
		{
			echo "OK, commit";
			$mysqli->commit();
		}
		else
		{
			echo "Error, rollback; " . $error;
			$mysqli->rollback(); 
		}

		/* Activar nuevamente autocommit */
		$mysqli->autocommit(TRUE);

    }
}