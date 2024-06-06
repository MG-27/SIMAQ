<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idproveedor = $_POST['idproveedor'];
$proveedor = $_POST['proveedor'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

$estado = $_POST['estado'];
$direccion = $_POST['direccion'];

$sql = "UPDATE proveedores SET proveedor='$proveedor', telefono='$telefono',email='$email',estado='$estado',direccion='$direccion' WHERE idproveedor=$idproveedor";


$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Proveedor actualizado correctamente",
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
          text: "Error al actualizar proveedor",
        }).then(function() {
            $("#sub-data").load("./views/proveedores/principal.php");
        });
    });
  </script>';
    cerrar_db();
}
