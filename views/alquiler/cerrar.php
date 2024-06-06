<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$idalquiler = $_POST['idalquiler'];
$sql = "UPDATE alquiler SET estado=1 WHERE idalquiler='$idalquiler'";
$result = $conn->query($sql);
?>

<?php if ($result === TRUE): ?>
    <script>
        $(document).ready(function() {
            let idalquiler = '<?php echo $idalquiler;?>';
            $("#sub-data").load("./views/alquiler/principal.php?idalquiler=" + idalquiler);
        });
    </script>
    <?php cerrar_db(); ?>
<?php else: ?>
    <script>
        $(document).ready(function() {
            alert('Error al cerrar venta...');
            $("#sub-data").load("./views/alquiler/principal.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>