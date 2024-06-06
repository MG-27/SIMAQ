<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idmaquina = $_POST['idmaquina'];
$sql = "DELETE FROM maquinas WHERE idmaquina=$idmaquina";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Maquinaria eliminada correctamente",
        }).then(function() {
            $("#sub-data").load("./views/maquinas/principal.php");
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
          text: "Error al eliminar maquinaria",
        }).then(function() {
            $("#sub-data").load("./views/maquinas/principal.php");
        });
    });
  </script>';
    cerrar_db();
}