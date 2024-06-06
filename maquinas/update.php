<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idmaquina = $_POST['idmaquina'];
$nombremaquina = $_POST['nombremaquina'];
$descripcion = $_POST['descripcion'];
$cantidadstock = $_POST['cantidadstock'];
$estado = $_POST['estado'];
$precioalquiler = $_POST['precioalquiler'];
$preciocompra = $_POST['preciocompra'];
$minimo = $_POST['minimo'];
$imgFile = $_FILES['imagenMaq']['name'];
$tmp_dir = $_FILES['imagenMaq']['tmp_name'];
$imgSize = $_FILES['imagenMaq']['size'];
$idproveedor = $_POST['idproveedor'];

if ($imgSize > 0) {
    $nombreArchivo = $idmaquina;
    $dir = dirname(__FILE__) . "/imgproductos";
    $directorio = str_replace('\\', '/', $dir) . '/';
    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
    $newName = $nombreArchivo . "." . $imgExt;

    $subir_archivo = $directorio . $newName;
    $img = $newName;

    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    if (copy($tmp_dir, $directorio . $newName)) {
        $subido = true;
    } else {
        $subido = false;
    }

    if ($subido === true) {
        $sql = "UPDATE maquinas SET nombremaquina='$nombremaquina', descripcion='$descripcion', cantidadstock='$cantidadstock',  preciocompra='$preciocompra', precioalquiler='$precioalquiler', minimo='$minimo', idproveedor='$idproveedor', estado='$estado'  WHERE idmaquina='$idmaquina'";

        // Ruta a la imagen que se actualizó
        $rutaImagen = $directorio . $newName;

        // Limpiar la caché de la imagen
        clearstatcache(true, $rutaImagen);

        $result = $conn->query($sql);

        if ($result === TRUE) {
            echo '<script>
            $(document).ready(function() {
                $("#sub-data").load("./views/maquinas/principal.php");
            });
        </script>';
            cerrar_db();
        } else {
            echo '<script>
        $(document).ready(function() {
            Swal.fire({
              icon: "error",
              title: "¡ERROR!",
              text: "Error al actualizar maquinaria",
            }).then(function() {
                $("#sub-data").load("./views/maquinas/principal.php");
            });
        });
      </script>';
            cerrar_db();
        }
    } else {
        echo '<script>
        $(document).ready(function() {
            Swal.fire({
              icon: "error",
              title: "¡ERROR!",
              text: "Error al cargar imagen",
            }).then(function() {
                $("#sub-data").load("./views/maquinas/principal.php");
            });
        });
      </script>';
        cerrar_db();
    }
} else {
    $sql = "UPDATE maquinas SET nombremaquina='$nombremaquina', descripcion='$descripcion', cantidadstock='$cantidadstock', preciocompra='$preciocompra', precioalquiler='$precioalquiler', minimo='$minimo', idproveedor='$idproveedor', estado='$estado'  WHERE idmaquina='$idmaquina'";

    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo '<script>
        $(document).ready(function() {
            Swal.fire({
              icon: "success",
              title: "¡DATOS ACTUALIZADOS!",
              text: "Maquinaria actualizada correctamente",
            }).then(function() {
                $("#sub-data").load("./views/maquinas/principal.php");
            });
        });
      </script>';
        cerrar_db();
    } else {
        echo '<script>
        $(document).ready(function() {
            Swal.fire({
              icon: "error",
              title: "¡ERROR!",
              text: "Error al actualizar maquinaria",
            }).then(function() {
                $("#sub-data").load("./views/maquinas/principal.php");
            });
        });
      </script>';
        cerrar_db();
    }
}
