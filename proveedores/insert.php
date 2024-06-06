<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$proveedor = $_POST['proveedor'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$estado = $_POST['estado'];
$direccion = $_POST['direccion'];

// Verificar si el proveedor ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM proveedores WHERE proveedor = '$proveedor'";
$result_check = $conn->query($sql_check);

if ($result_check) {
    $row = $result_check->fetch_assoc();
    $count = $row['count'];
    //echo "<script>alert('Count: $count');</script>"; // Agregar esta línea para ver el valor de $count
    
    if ($count > 0) {
        // El proveedor ya existe, mostrar mensaje de error
        echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "warning",
                  title: "ADVERTENCIA!",
                  text: "Proveedor ya existe en el registro",
                }).then(function() {
                    $("#sub-data").load("./views/proveedores/principal.php");
                });
            });
        </script>';
    } else {
        // El proveedor no existe, proceder con la inserción
        $sql_insert = "INSERT INTO proveedores(proveedor, telefono, email, estado, direccion) 
                       VALUES('$proveedor', '$telefono', '$email', '$estado', '$direccion')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert === TRUE) {
            echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "success",
                  title: "¡DATOS INGRESADOS!",
                  text: "Proveedor registrado correctamente",
                }).then(function() {
                    $("#sub-data").load("./views/proveedores/principal.php");
                });
            });
        </script>';
        } else {
            echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "error",
                  title: "¡Error!",
                  text: "Error al registrar proveedor",
                }).then(function() {
                    $("#sub-data").load("./views/proveedores/principal.php");
                });
            });
        </script>';
        }
    }
} else {
    echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "error",
                  title: "¡Error!",
                  text: "Error en el proceso",
                }).then(function() {
                    $("#sub-data").load("./views/proveedores/principal.php");
                });
            });
        </script>';
}

cerrar_db();
?>
