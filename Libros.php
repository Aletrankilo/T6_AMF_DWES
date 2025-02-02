<?php
class Libros {
    private $conexion;

    /**
     * Establece la conexión a la base de datos.
     * @param string $servidor Servidor de la base de datos (localhost)
     * @param string $usuario Usuario de la base de datos (root por defecto en XAMPP)
     * @param string $password Contraseña del usuario (vacía por defecto en XAMPP)
     * @param string $baseDatos Nombre de la base de datos (Libros)
     * @return mysqli|null Retorna el objeto de conexión o null si falla.
     */
    public function conexion($servidor, $usuario, $password, $baseDatos) {
        $this->conexion = new mysqli($servidor, $usuario, $password, $baseDatos);

        // Si hay error en la conexión, se cierra y se retorna null
        if ($this->conexion->connect_error) {
            $this->cerrarConexion();
            return null;
        }

        return $this->conexion;
    }

    /**
     * Cierra la conexión con la base de datos si está abierta.
     */
    public function cerrarConexion() {
        if ($this->conexion instanceof mysqli) {
            $this->conexion->close();
        }
    }

    /**
     * Consulta autores en la base de datos.
     * @param mysqli $conexion Conexión a la base de datos.
     * @param int|null $idAutor ID del autor (opcional).
     * @return array|null Retorna un array con los autores o null si hay error.
     */
    public function consultarAutores($conexion, $idAutor = null) {
        $sql = "SELECT * FROM Autor";
        
        if ($idAutor !== null) {
            $sql .= " WHERE id = ?";
        }

        $stmt = $conexion->prepare($sql);

        if ($idAutor !== null) {
            $stmt->bind_param("i", $idAutor);
        }

        if (!$stmt->execute()) {
            return null;
        }

        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Consulta libros en la base de datos.
     * @param mysqli $conexion Conexión a la base de datos.
     * @param int|null $idAutor ID del autor (opcional).
     * @return array|null Retorna un array con los libros o null si hay error.
     */
    public function consultarLibros($conexion, $idAutor = null) {
        $sql = "SELECT * FROM Libro";

        if ($idAutor !== null) {
            $sql .= " WHERE id_autor = ?";
        }

        $stmt = $conexion->prepare($sql);

        if ($idAutor !== null) {
            $stmt->bind_param("i", $idAutor);
        }

        if (!$stmt->execute()) {
            return null;
        }

        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Consulta los datos de un libro según su ID.
     * @param mysqli $conexion Conexión a la base de datos.
     * @param int $idLibro ID del libro a consultar.
     * @return array|null Retorna un array con los datos del libro o null si hay error.
     */
    public function consultarDatosLibro($conexion, $idLibro) {
        $sql = "SELECT * FROM Libro WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idLibro);

        if (!$stmt->execute()) {
            return null;
        }

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    /**
     * Elimina un autor y sus libros de la base de datos.
     * @param mysqli $conexion Conexión a la base de datos.
     * @param int $idAutor ID del autor a eliminar.
     * @return bool Retorna true si se eliminó correctamente, false si hubo un error.
     */
    public function borrarAutor($conexion, $idAutor) {
        // Primero eliminar todos los libros del autor
        $sqlLibros = "DELETE FROM Libro WHERE id_autor = ?";
        $stmtLibros = $conexion->prepare($sqlLibros);
        $stmtLibros->bind_param("i", $idAutor);
        
        if (!$stmtLibros->execute()) {
            return false; // No se pudieron eliminar los libros
        }

        // Ahora eliminar al autor
        $sqlAutor = "DELETE FROM Autor WHERE id = ?";
        $stmtAutor = $conexion->prepare($sqlAutor);
        $stmtAutor->bind_param("i", $idAutor);

        if ($stmtAutor->execute() && $stmtAutor->affected_rows > 0) {
            return true; // Eliminación exitosa
        } else {
            return false; // Error o no se encontró el autor
        }
    }

    /**
     * Elimina un libro de la base de datos.
     * @param mysqli $conexion Conexión a la base de datos.
     * @param int $idLibro ID del libro a eliminar.
     * @return bool Retorna true si se eliminó correctamente, false si hubo un error.
     */
    public function borrarLibro($conexion, $idLibro) {
        $sql = "DELETE FROM Libro WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idLibro);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return true; // Eliminación exitosa
        } else {
            return false; // Error o no se encontró el libro
        }
    }
}
?>
