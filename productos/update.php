<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Verificar si se ha enviado el formulario de actualización del producto
if (isset($_POST['accion']) && $_POST['accion'] == 'update') {
    // Obtener los datos del formulario de actualización del producto
    $idproducto = $_POST['idproducto'];
    $producto = $_POST['producto'];
    $detalle = $_POST['detalle'];
    $stock = $_POST['stock'];
    $estado = $_POST['estado'];
    $pventa = $_POST['pventa'];
    $pcompra = $_POST['pcompra'];
    $minimo = $_POST['minimo'];
    $imgFile = $_FILES['imagenProd']['name'];
    $tmp_dir = $_FILES['imagenProd']['tmp_name'];
    $imgSize = $_FILES['imagenProd']['size'];
    $idproveedor = $_POST['idproveedor'];
    $idcategoria = $_POST['idcategoria'];

    // Actualizar el producto en la base de datos
    $sql = "UPDATE productos SET producto='$producto', detalle='$detalle', stock='$stock', pventa='$pventa', pcompra='$pcompra', minimo='$minimo', idproveedor='$idproveedor', idcategoria='$idcategoria', estado='$estado' WHERE idproducto='$idproducto'";

    $result = $conn->query($sql);

    // Verificar si la consulta se ejecutó correctamente
    if ($result === TRUE) {
        // Mostrar mensaje de éxito y recargar la página
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: "success",
                        title: "¡DATOS ACTUALIZADOS!",
                        text: "Producto actualizado correctamente",
                    }).then(function() {
                        $("#sub-data").load("./views/productos/principal.php");
                    });
                });
            </script>';
        cerrar_db();
    } else {
        // Mostrar mensaje de error y recargar la página
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: "error",
                        title: "¡ERROR!",
                        text: "Error al actualizar producto",
                    }).then(function() {
                        $("#sub-data").load("./views/productos/principal.php");
                    });
                });
            </script>';
        cerrar_db();
    }
} else {
    // Si la solicitud no proviene del formulario de actualización del producto,
    // no se realiza ninguna acción.
}
?>
