<?php
require_once 'Libros.php';

// Se crea un objeto de la clase Libros
$libros = new Libros();

// Se intenta establecer conexión con la base de datos
$conexion = $libros->conexion("localhost", "root", "", "Libros");

if ($conexion) {
    echo "Conexión exitosa a la base de datos.<br>";
} else {
    echo "Error en la conexión a la base de datos.<br>";
}

// Se cierra la conexión manualmente
$libros->cerrarConexion();
echo "Conexión cerrada correctamente.";
?>
