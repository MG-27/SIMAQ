<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$idalquiler = $_POST['idalquiler'];
$idmaquina = $_POST['idmaquina'];
$cantidad = $_POST['cantidad'];
$precioalquiler = $_POST['precioalquiler'];
$total = $cantidad * $precioalquiler;
$estado = 1;
$encargado="No Definido";
$fecha = date("Y-m-d");

// Insertar en detallealquiler
$sqlDetalleAlquiler = "INSERT INTO detallealquiler(idalquiler, idmaquina, cantidad, total, estado, fecha) 
                      VALUES('$idalquiler', '$idmaquina', '$cantidad', '$total', '$estado', '$fecha')";
$resultDetalleAlquiler = $conn->query($sqlDetalleAlquiler);

// Insertar en estadomaquinas
if ($resultDetalleAlquiler === TRUE) {
    $sqlEstadoMaquinas = "INSERT INTO estadomaquinas(idalquiler, idmaquina, cantidad, total, estado, encargado, fecha) 
                          VALUES('$idalquiler', '$idmaquina', '$cantidad', '$total', '$estado', '$encargado', '$fecha')";
    $resultEstadoMaquinas = $conn->query($sqlEstadoMaquinas);
    
    if ($resultEstadoMaquinas === TRUE) {
        // Actualizar el stock en maquinas
        $sqlBuscaStock = "SELECT cantidadstock FROM maquinas WHERE idmaquina='$idmaquina'";
        $resultBuscaStock = $conn->query($sqlBuscaStock);
        $row = $resultBuscaStock->fetch_assoc();
        $oldStock = $row['cantidadstock'];
        $newStock = $oldStock - $cantidad;
        
        $sqlUpdateStock = "UPDATE maquinas SET cantidadstock='$newStock' WHERE idmaquina='$idmaquina'";
        $resultUpdateStock = $conn->query($sqlUpdateStock);
        
        if ($resultUpdateStock === TRUE) {
            ?>
            <script>
                $(document).ready(function() {
                    $("#DataVentas").load("./views/alquiler/prealquiler.php");
                });
            </script>
            <?php 
        } else {
            ?>
            <script>
                $(document).ready(function() {
                    alert('Error al actualizar el stock de la máquina');
                    $("#sub-data").load("./views/alquiler/principal.php");
                });
            </script>
            <?php 
        }
    } else {
        ?>
        <script>
            $(document).ready(function() {
                alert('Error al agregar máquina en estadomaquinas');
                $("#sub-data").load("./views/alquiler/principal.php");
            });
        </script>
        <?php 
    }
} else {
    ?>
    <script>
        $(document).ready(function() {
            alert('Error al agregar máquina en detallealquiler');
            $("#sub-data").load("./views/alquiler/principal.php");
        });
    </script>
    <?php 
}

cerrar_db(); 
?>

