<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$alquilerEstado0 = "SELECT * FROM alquiler WHERE estado=0 AND idusuario='$idusuario'";
$result = $conn->query($alquilerEstado0);
$row = $result->fetch_assoc();
$idalquiler = $row['idalquiler'];
$cliente = $row['nombrecliente'];

// Consulta para obtener más información del cliente
$clienteInfoQuery = "SELECT * FROM clientes WHERE nombrecliente = '$cliente'";
$clienteResult = $conn->query($clienteInfoQuery);
$clienteData = $clienteResult->fetch_assoc();

$sql = "SELECT * FROM maquinas WHERE cantidadstock > 0 AND estado = 1";
$dataMaquinas = $conn->query($sql);

$sqlDA = "SELECT * FROM detallealquiler WHERE idalquiler='$idalquiler' AND estado = 1";
$detallesAlquiler = $conn->query($sqlDA);

$contMaquinas = 0;
$contMaquinasDA = 0;
$contTmaquinas = 0;
$contTotalMaquinas = 0;
?>
<div>
    <p style="text-align: center;"><b>DATOS DEL CLIENTE</b></p>
    <hr>
    <?php if ($clienteData) : ?>
        <b>Nombre del Cliente: <?php echo $clienteData['nombrecliente']; ?></b>
        <br>
        <b>DUI: <?php echo $clienteData['dui']; ?></b>
        <br>
        <b>Teléfono: <?php echo $clienteData['telefono']; ?></b>
        <br>
        <b>Email: <?php echo $clienteData['email']; ?></b>
        <br>
        <b>Dirección: <?php echo $clienteData['direccion']; ?></b>
        <hr>
    <?php endif ?>
</div>

<div>
    <p style="text-align: center;"><b>Agregar Máquinas al Alquiler</b></p>
    <hr>
    <i class="fa-solid fa-clipboard-check"></i> : <b>Cerrar Alquiler</b> | <i class="fa-solid fa-eraser"></i> : <b>Eliminar Alquiler</b>
    <hr>
    <hr>
    <?php if ($detallesAlquiler && $detallesAlquiler->num_rows > 0) : ?>
        <!-- Código para mostrar detalles de alquiler -->
    <?php else : ?>
        <!-- Código para indicar que no hay máquinas agregadas al carrito -->
    <?php endif ?>
</div>

<hr>
<!--Cuadro que me permite agregar las máquinas que desee al alquiler-->
<p style="text-align: center;"><b>Inventario</b></p>
<hr>
<div>
    <?php if ($dataMaquinas && $dataMaquinas->num_rows > 0) : ?>
        <!-- Código para mostrar inventario de máquinas -->
    <?php else : ?>
        <!-- Código para indicar que no hay máquinas disponibles -->
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>
