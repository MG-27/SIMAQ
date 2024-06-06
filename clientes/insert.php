<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$nombrecliente = $_POST['nombrecliente'];
$dui= $_POST['dui'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$estado = $_POST['estado'];
$direccion = $_POST['direccion'];

// Verificar si el cliente ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM clientes WHERE nombrecliente = '$nombrecliente'";
$result_check = $conn->query($sql_check);


if ($result_check) {
    $row = $result_check->fetch_assoc();
    $count = $row['count'];
    if ($row['count'] > 0) {
        // El cliente ya existe, mostrar mensaje de error
        echo '<script>
            $(document).ready(function() {
                Swal.fire({
                icon: "warning",
                title: "¡ADVERTENCIA!",
                text: "Cliente ya existe en el registro",
                }).then(function() {
                    $("#sub-data").load("./views/clientes/principal.php");
                });
            });
        </script>';
    } else {
        // El cliente no existe, proceder con la inserción
        $sql_insert = "INSERT INTO clientes(nombrecliente, dui,telefono, email, estado, direccion) 
                    VALUES('$nombrecliente', '$dui', '$telefono', '$email', '$estado', '$direccion')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert === TRUE) {
            echo '<script>
            $(document).ready(function() {
                Swal.fire({
                icon: "success",
                title: "¡DATOS INGRESADOS!",
                text: "Cliente registrado correctamente",
                }).then(function() {
                    $("#sub-data").load("./views/clientes/principal.php");
                });
            });
        </script>';
    } else {
        
        echo '<script>
            $(document).ready(function() {
                Swal.fire({
                icon: "error",
                title: "¡Error!",
                text: "Error al registrar cliente",
                }).then(function() {
                    $("#sub-data").load("./views/clientes/principal.php");
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
                    $("#sub-data").load("./views/clientes/principal.php");
                });
            });
        </script>';
}

cerrar_db();
?>