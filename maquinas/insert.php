<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$nombremaquina = $_POST['nombremaquina'];
$descripcion = $_POST['descripcion'];
$cantidadstock = $_POST['cantidadstock'];
$estado = $_POST['estado'];
$preciocompra = $_POST['preciocompra'];
$precioalquiler = $_POST['precioalquiler'];
$minimo = $_POST['minimo'];
$imgFile = $_FILES['imagenMaq']['name'];
$tmp_dir = $_FILES['imagenMaq']['tmp_name'];
$imgSize = $_FILES['imagenMaq']['size'];
$idproveedor = $_POST['idproveedor'];

// Verificar si el producto ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM maquinas WHERE nombremaquina = '$nombremaquina'";
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
                    text: "La maquinaria ya existe en el registro",
                    }).then(function() {
                        $("#sub-data").load("./views/maquinas/principal.php");
                    });
                });
            </script>';
    } else {
        // El producto no existe, proceder con la inserción
        $sqlMaxid = "SELECT MAX(idmaquina) AS idmaquina FROM maquinas";
        $resultMaxId = $conn->query($sqlMaxid);
        $rowMaxId = $resultMaxId->fetch_assoc();
        $idmaquina = $rowMaxId['idmaquina'] + 1;

        $dir = dirname(__FILE__) . "/imgmaquinas";
        $directorio = str_replace('\\', '/', $dir) . '/';
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
        $newName = $idmaquina . "." . $imgExt;
        $subir_archivo = $directorio . $newName;
        $img = $newName;

        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        if (move_uploaded_file($tmp_dir, $directorio . $newName)) {
            // La imagen se subió correctamente, proceder con la inserción del producto
            $sql = "INSERT INTO maquinas(idmaquina, nombremaquina, descripcion, cantidadstock, preciocompra, precioalquiler, minimo, img, idproveedor, estado)
                    VALUES('$idmaquina', '$nombremaquina', '$descripcion', '$cantidadstock', '$preciocompra', '$precioalquiler', '$minimo', '$img', '$idproveedor', '$estado')";

            $result = $conn->query($sql);

            if ($result === TRUE) {
                echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "success",
                    title: "¡DATOS INGRESADOS!",
                    text: "Maquinaria registrada correctamente",
                    }).then(function() {
                        $("#sub-data").load("./views/maquinas/principal.php");
                    });
                });
            </script>';
        } else {
            echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "ERROR",
                    title: "¡Error!",
                    text: "Error al registrar maquinaria",
                    }).then(function() {
                        $("#sub-data").load("./views/maquinas/principal.php");
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
                    text: "Error con imagen",
                    }).then(function() {
                        $("#sub-data").load("./views/maquinas/principal.php");
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
                    $("#sub-data").load("./views/maquinas/principal.php");
                });
            });
        </script>';
}
cerrar_db();
?>
