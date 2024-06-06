<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idusuario = $_POST['idusuario'];
$usuario = $_POST['usuario'];
$empleado = $_POST['empleado'];
if (strlen($_POST['clave']) != 0) {
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
}
$estado = $_POST['estado'];
$tipo = $_POST['tipo'];
if (strlen($_POST['clave']) != 0) {
    $sql = "UPDATE usuarios SET usuario='$usuario', empleado='$empleado',clave='$clave',estado='$estado',tipo='$tipo' WHERE idusuario=$idusuario";
} else {
    $sql = "UPDATE usuarios SET usuario='$usuario', empleado='$empleado',estado='$estado',tipo='$tipo' WHERE idusuario=$idusuario";
}

$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Usuario actualizado correctamente",
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
              text: "Error al actualizar usuario",
            }).then(function() {
                $("#sub-data").load("./views/usuarios/principal.php");
            });
        });
      </script>';
    cerrar_db();
}
