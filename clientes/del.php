<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idcliente = $_POST['idcliente'];
$sql = "DELETE FROM clientes WHERE idcliente=$idcliente";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Cliente eliminado correctamente",
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
          text: "Error al eliminar cliente",
        }).then(function() {
            $("#sub-data").load("./views/clientes/principal.php");
        });
    });
  </script>';
    cerrar_db();
}