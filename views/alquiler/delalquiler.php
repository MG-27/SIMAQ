<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$idalquiler = $_POST['idalquiler'];

$sql = "DELETE FROM alquiler WHERE idalquiler = ? AND idusuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idalquiler, $idusuario);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Registro de alquiler eliminado correctamente';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error al eliminar el registro de alquiler';
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
