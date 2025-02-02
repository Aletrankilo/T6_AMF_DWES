<?php
require_once 'Libros.php';

// Se crea un objeto de la clase Libros
$libros = new Libros();

// Se establece la conexión con la base de datos
$conexion = $libros->conexion("localhost", "root", "", "Libros");

if (!$conexion) {
    die("Error al conectar con la base de datos.");
}

// Consultar todos los autores
echo "<h3>Lista de autores:</h3>";
$autores = $libros->consultarAutores($conexion);
if ($autores) {
    foreach ($autores as $autor) {
        echo "ID: " . $autor['id'] . " - " . $autor['nombre'] . " " . $autor['apellidos'] . " (" . $autor['nacionalidad'] . ")<br>";
    }
} else {
    echo "No se encontraron autores.<br>";
}

// Consultar los libros de un autor específico (ejemplo: Tolkien)
echo "<h3>Libros de J. R. R. Tolkien:</h3>";
$librosAutor = $libros->consultarLibros($conexion, 0);
if ($librosAutor) {
    foreach ($librosAutor as $libro) {
        echo "ID: " . $libro['id'] . " - " . $libro['titulo'] . " (Publicado el: " . $libro['f_publicacion'] . ")<br>";
    }
} else {
    echo "No se encontraron libros para este autor.<br>";
}

// Consultar los datos de un libro específico (ejemplo: "El Hobbit")
echo "<h3>Datos del libro 'El Hobbit':</h3>";
$datosLibro = $libros->consultarDatosLibro($conexion, 0);
if ($datosLibro) {
    echo "ID: " . $datosLibro['id'] . "<br>";
    echo "Título: " . $datosLibro['titulo'] . "<br>";
    echo "Fecha de publicación: " . $datosLibro['f_publicacion'] . "<br>";
    echo "ID del autor: " . $datosLibro['id_autor'] . "<br>";
} else {
    echo "No se encontraron datos para este libro.<br>";
}

// Cerrar la conexión al finalizar
$libros->cerrarConexion();
echo "<br>Conexión cerrada correctamente.";
?>
