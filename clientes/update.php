<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idcliente = $_POST['idcliente'];
$nombrecliente = $_POST['nombrecliente'];
$dui = $_POST['dui'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

$estado = $_POST['estado'];
$direccion = $_POST['direccion'];

$sql = "UPDATE clientes SET nombrecliente='$nombrecliente', telefono='$telefono',email='$email',estado='$estado',direccion='$direccion' WHERE idcliente=$idcliente";


$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Cliente actualizado correctamente",
        }).then(function() {
            $("#sub-data").load("./views/clientes/principal.php");
        });
    });
  </script>';
    cerrar_db();
} else {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "error",
          title: "¡ERROR!",
          text: "Error al actualizar cliente",
        }).then(function() {
            $("#sub-data").load("./views/clientes/principal.php");
        });
    });
  </script>';
    cerrar_db();
}