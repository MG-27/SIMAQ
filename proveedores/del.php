<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idproveedor = $_POST['idproveedor'];
$sql = "DELETE FROM proveedores WHERE idproveedor=$idproveedor";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Proveedor eliminado correctamente",
        }).then(function() {
            $("#sub-data").load("./views/proveedores/principal.php");
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
          text: "Error al eliminar proveedor",
        }).then(function() {
            $("#sub-data").load("./views/proveedores/principal.php");
        });
    });
  </script>';
    cerrar_db();
}