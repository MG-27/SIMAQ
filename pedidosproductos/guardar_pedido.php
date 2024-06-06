<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Obtener los datos del formulario
$nombre_producto = $_POST['nombre_producto']; // Nombre del producto
$cantidad = $_POST['stock']; // Cantidad a pedir

// Consultar la base de datos para obtener más detalles del producto
$sql = "SELECT * FROM productos WHERE producto = '$nombre_producto'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Obtener otros detalles del producto
$idproducto = $row['idproducto']; // ID del producto
$producto = $row['producto']; // Nombre del producto
$estado = 1; // Estado del pedido (suponiendo que 1 significa activo)
$fecha = date('Y-m-d'); // Fecha actual

// Generar número de orden único (puedes adaptar esto según tus necesidades)
$numero_orden = uniqid();

// Insertar el pedido en la base de datos
$sql_insert = "INSERT INTO pedidos (idproducto, nombre_producto, cantidad, estado, fecha, numero_orden) 
               VALUES ('$idproducto', '$producto', '$cantidad', '$estado', '$fecha', '$numero_orden')";

$result_insert = $conn->query($sql_insert);

// Verificar si el pedido se insertó correctamente
if ($result_insert === TRUE) {    
    // Mostrar mensaje de éxito y recargar la página
    echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "success",
                  title: "¡DATOS INGRESADOS!",
                  text: "Pedido registrado correctamente",
                }).then(function() {
                    location.reload();
                });
            });
          </script>';
} else {
    // Mostrar mensaje de error y recargar la página
    echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "error",
                  title: "¡ERROR!",
                  text: "Error al guardar el pedido",
                }).then(function() {
                    location.reload();
                });
            });
          </script>';
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
