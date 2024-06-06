<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlMaxid = "SELECT MAX(idalquiler) AS idalquiler FROM alquiler";

$resultMaxId = $conn->query($sqlMaxid);
$rowMaxId = $resultMaxId->fetch_assoc();
$idalquiler = $rowMaxId['idalquiler'] + 1;
$nombrecliente = $_POST['nombrecliente'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$tipo_alquiler = $_POST['tipo_alquiler'];
$idusuario = $_SESSION['idusuario'];
$fecha = date("Y-m-d H:i:s");
$estado = 0;
$sql = "INSERT INTO alquiler(idalquiler, nombrecliente, fecha_inicio, fecha_fin, tipo_alquiler, idusuario, fecha, estado) VALUES('$idalquiler', '$nombrecliente', '$fecha_inicio', '$fecha_fin', '$tipo_alquiler', '$idusuario', '$fecha', '$estado')";

$result = $conn->query($sql);
?>

<?php if ($result === TRUE): ?>
    <script>
        $(document).ready(function() {
            $("#DataVentas").load("./views/alquiler/prealquiler.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php else: ?>
    <script>
        $(document).ready(function() {
            alert('Error al registrar venta...');
            $("#sub-data").load("./views/alquiler/principal.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>
