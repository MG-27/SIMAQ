<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Imprimir los datos recibidos del formulario
//var_dump($_POST);

// Obtener los datos del formulario
$idestadomaquina = $_POST['idestadomaquina']; 
$estado = $_POST['estado']; // Cambiar el nombre del campo si es diferente en tu tabla

// Verificar si los valores recibidos son los esperados
if (!isset($idestadomaquina) || !isset($estado)) {
    echo "Error: Faltan datos en el formulario.";
    cerrar_db();
    exit;
}

//echo "Valores recibidos correctamente.";

// Verificar si el estado actual es "En uso" (1) para cambiarlo a "Disponible" (0)
if ($estado == 1) {
    //echo "El estado actual es 'En uso'.";
    
    // Actualizar el estado en la tabla detallealquiler
    $sql_update_estado = "UPDATE estadomaquinas SET estado = 0 WHERE idestadomaquina = '$idestadomaquina'";
    if ($conn->query($sql_update_estado) === TRUE) {
        //echo "estado actualizado en detallealquiler.";
        echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "success",
                  title: "¡DATOS ACTUALIZADOS!",
                  text: "El estado de la máquina ha sido actualizado",
                }).then(function() {
                    $("#sub-data").load("./views/estadosalquiler/principal.php");
                });
            });
        </script>';
        
        // Obtener el idmaquina correspondiente al idestadomaquina
        $query_maquina = "SELECT idmaquina, cantidad FROM estadomaquinas WHERE idestadomaquina = '$idestadomaquina'";
        $result_maquina = $conn->query($query_maquina);
        if ($result_maquina->num_rows > 0) {
            $row_maquina = $result_maquina->fetch_assoc();
            $idmaquina = $row_maquina['idmaquina'];
            $cantidad = $row_maquina['cantidad'];

            // Obtener el stock actual de la máquina
            $query_stock = "SELECT cantidadstock FROM maquinas WHERE idmaquina = '$idmaquina'";
            $result_stock = $conn->query($query_stock);
            if ($result_stock->num_rows > 0) {
                $row_stock = $result_stock->fetch_assoc();
                $old_stock = $row_stock['cantidadstock'];

                // Calcular el nuevo stock sumando la cantidad al stock existente
                $new_stock = $old_stock + $cantidad;

                // Actualizar el stock en la tabla maquinas
                $sql_update_stock = "UPDATE maquinas SET cantidadstock = '$new_stock' WHERE idmaquina = '$idmaquina'";
                if ($conn->query($sql_update_stock) === TRUE) {
                    //echo "Stock actualizado en maquinas.";
                    //echo "estado actualizado correctamente y cantidad añadida al stock.";
                } else {
                    //echo "Error al actualizar el stock: " . $conn->error;
                }
            } else {
                //echo "No se encontró la máquina en la tabla maquinas.";
            }
        } else {
           // echo "No se encontró el detalle de alquiler en la tabla detallealquiler.";
        }
    } else {
        echo '<div class="custom-alert">Error al registrar producto...</div>';
        echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "ERROR",
                  title: "¡Error!",
                  text: "Error al actualizar estado de la maquinaria en alquiler",
                }).then(function() {
                    $("#sub-data").load("./views/estadosalquiler/principal.php");
                });
            });
        </script>';
        //echo "Error al actualizar el estado: " . $conn->error;
    }

    // Cerrar la conexión
    cerrar_db();
} else {
    // El estado ya está disponible, no se requiere hacer cambios
    //echo "El estado ya está disponible, no se requiere hacer cambios.";
    cerrar_db();
}
?>
