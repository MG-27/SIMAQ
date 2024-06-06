<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idusuario = $_POST['idusuario'];
$sql = "DELETE FROM usuarios WHERE idusuario=$idusuario";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Usuario eliminado correctamente",
        }).then(function() {
            $("#sub-data").load("./views/usuarios/principal.php");
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
          text: "Error al eliminar usuario",
        }).then(function() {
            $("#sub-data").load("./views/usuarios/principal.php");
        });
    });
  </script>';
    cerrar_db();
}