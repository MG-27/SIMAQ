<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$iddetallealquiler = $_POST['iddetallealquiler'];
$BuscadataDA = "SELECT * FROM detallealquiler WHERE iddetallealquiler='$iddetallealquiler'";
$resultStock = $conn->query($BuscadataDA);
$rowDA = $resultStock->fetch_assoc();
$idmaquina = $rowDA['idmaquina'];
$cantidad = $rowDA['cantidad'];

$sql = "DELETE FROM detallealquiler WHERE iddetallealquiler='$iddetallealquiler'";

$result = $conn->query($sql);
?>

<?php if ($result === TRUE) : ?>
    <?php
    $BuscadataMaquina = "SELECT cantidadstock FROM maquinas WHERE idmaquina='$idmaquina'";
    $resultStock = $conn->query($BuscadataMaquina);
    $row = $resultStock->fetch_assoc();
    $oldstock = $row['cantidadstock'];
    $nstock = $oldstock + $cantidad;
    $sqlUpdStock = "UPDATE maquinas SET cantidadstock='$nstock' WHERE idmaquina='$idmaquina'";
    $conn->query($sqlUpdStock);
    ?>
    <script>
        $(document).ready(function() {
            $("#DataVentas").load("./views/alquiler/prealquiler.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php else : ?>
    <script>
        $(document).ready(function() {
            alert('Error al eliminar máquina...');
            $("#sub-data").load("./views/alquiler/prealquiler.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>
