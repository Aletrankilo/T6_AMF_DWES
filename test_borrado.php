<?php
require_once 'Libros.php';

// Se crea un objeto de la clase Libros
$libros = new Libros();

// Se establece la conexión con la base de datos
$conexion = $libros->conexion("localhost", "root", "", "Libros");

if (!$conexion) {
    die("Error al conectar con la base de datos.");
}

// Prueba de eliminación de un libro (ejemplo: "El Hobbit", id = 0)
echo "<h3>Intentando eliminar el libro 'El Hobbit'...</h3>";
if ($libros->borrarLibro($conexion, 0)) {
    echo "Libro eliminado correctamente.<br>";
} else {
    echo "Error al eliminar el libro o no existe.<br>";
}

// Prueba de eliminación de un autor (ejemplo: J. R. R. Tolkien, id = 0)
// ⚠ Nota: Para eliminar un autor, primero deben eliminarse sus libros asociados.
echo "<h3>Intentando eliminar al autor J. R. R. Tolkien...</h3>";
if ($libros->borrarAutor($conexion, 0)) {
    echo "Autor eliminado correctamente.<br>";
} else {
    echo "Error al eliminar el autor o tiene libros asociados.<br>";
}

// Cerrar la conexión al finalizar
$libros->cerrarConexion();
echo "<br>Conexión cerrada correctamente.";
?>
