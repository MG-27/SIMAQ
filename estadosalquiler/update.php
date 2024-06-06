<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Capturar el ID de la maquina y el encargado del formulario POST
$idestadomaquina = $_POST['idestadomaquina'];
$encargado = $_POST['encargado'];

try {
    // Intentar ejecutar la actualización en la base de datos
    $sql = "UPDATE estadomaquinas SET encargado='$encargado' WHERE idestadomaquina=$idestadomaquina";
    $result = $conn->query($sql);

    // Verificar si la actualización fue exitosa
    if ($result === TRUE) {
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                      icon: "success",
                      title: "¡DATOS ACTUALIZADOS!",
                      text: "Categoría actualizada correctamente",
                    }).then(function() {
                        $("#sub-data").load("./views/estadosalquiler/principal.php");
                    });
                });
              </script>';
    } else {
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                      icon: "error",
                      title: "¡ERROR!",
                      text: "Error al actualizar la categoría",
                    }).then(function() {
                        $("#sub-data").load("./views/estadosalquiler/principal.php");
                    });
                });
              </script>';
    }
} catch (Exception $e) {
    // Capturar y mostrar cualquier excepción que ocurra durante la actualización
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    console.log($e);
}

// Cerrar la conexión a la base de datos
cerrar_db();
?>
