<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

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

// Verificar si el producto ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM productos WHERE producto = '$producto'";
$result_check = $conn->query($sql_check);


if ($result_check) {
    $row = $result_check->fetch_assoc();
    $count = $row['count'];

    if ($row['count'] > 0) {
        // El producto ya existe, mostrar mensaje de error
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "warning",
                    title: "¡ADVERTENCIA!",
                    text: "El producto ya esta registrado",
                    }).then(function() {
                        $("#sub-data").load("./views/productos/principal.php");
                    });
                });
            </script>';
    } else {
        // El producto no existe, proceder con la inserción
        $sqlMaxid = "SELECT MAX(idproducto) AS idproducto FROM productos";
        $resultMaxId = $conn->query($sqlMaxid);
        $rowMaxId = $resultMaxId->fetch_assoc();
        $idproducto = $rowMaxId['idproducto'] + 1;

        $dir = dirname(__FILE__) . "/imgproductos";
        $directorio = str_replace('\\', '/', $dir) . '/';
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
        $newName = $idproducto . "." . $imgExt;
        $subir_archivo = $directorio . $newName;
        $img = $newName;

        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        if (move_uploaded_file($tmp_dir, $directorio . $newName)) {
            // La imagen se subió correctamente, proceder con la inserción del producto
            $sql = "INSERT INTO productos(idproducto, producto, detalle, stock, pventa, pcompra, minimo, img, idproveedor, idcategoria, estado)
                    VALUES('$idproducto', '$producto', '$detalle', '$stock', '$pventa', '$pcompra', '$minimo', '$img', '$idproveedor', '$idcategoria', '$estado')";

            $result = $conn->query($sql);

            if ($result === TRUE) {
                echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "success",
                    title: "¡DATOS INGRESADOS!",
                    text: "Producto registrado correctamente",
                    }).then(function() {
                        $("#sub-data").load("./views/productos/principal.php");
                    });
                });
            </script>';
        } else {
            echo '<div class="custom-alert">Error al registrar producto...</div>';
            echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "ERROR",
                    title: "¡Error!",
                    text: "Error al registrar producto",
                    }).then(function() {
                        $("#sub-data").load("./views/productos/principal.php");
                    });
                });
            </script>';
            }
        } else {
            // Error al subir la imagen
            echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "ERROR",
                    title: "¡Error!",
                    text: "Error con imagen del producto",
                    }).then(function() {
                        $("#sub-data").load("./views/productos/principal.php");
                    });
                });
            </script>';
        }
    }
} else {
    echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "error",
                  title: "¡Error!",
                  text: "Error en el proceso",
                }).then(function() {
                    $("#sub-data").load("./views/productos/principal.php");
                });
            });
        </script>';
}

cerrar_db();
?>
