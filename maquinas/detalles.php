<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idmaquina = $_GET['idmaquina'];
$sql = "SELECT * FROM maquinas WHERE idmaquina = '$idmaquina'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nombremaquina = $row['nombremaquina'];
$descripcion = $row['descripcion'];
$cantidadstock = $row['cantidadstock'];
$precioalquiler = $row['precioalquiler'];
$precioalquiler = $row['precioalquiler'];
$minimo = $row['minimo'];
$img = $row['img'];
$idproveedor = $row['idproveedor'];
$sqlProveedor = $conn->query("SELECT proveedor FROM proveedores WHERE idproveedor = '$idproveedor'");
$rowPv = $sqlProveedor->fetch_assoc();
$vproveedor = $rowPv['proveedor'];

$estado = $row['estado'];
$vestado = ($estado == 1) ? 'Disponible' : 'No Disponible';

$sqlProv = "SELECT * FROM proveedores WHERE idproveedor != '$idproveedor'";
$DataProveedores = $conn->query($sqlProv);

?>
<input type="hidden" value="2" id="accion">
<input type="hidden" value="<?php echo $idmaquina; ?>" name="idmaquina">
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Máquina</b></span>
            <textarea disabled class="form-control" name="nombremaquina" placeholder="Ingrese Nombres de la maquinaria" id="nombremaquina"><?php echo $nombremaquina; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Descripción</b></span>
            <textarea disabled class="form-control" style="height: 200px;" name="descripcion" placeholder="Descripción de nombremaquina" id="descripcion"><?php echo $descripcion; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>cantidad en stock</b></span>
            <input disabled type="text" class="form-control" placeholder="cantidad en stock" name="cantidadstock" id="cantidadstock" value="<?php echo $cantidadstock; ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>cantidad de stock Minimo</b></span>
            <input disabled type="text" class="form-control" name="minimo" id="minimo" value="<?php echo $minimo; ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Precio Compra</b></span>
            <input disabled type="text" class="form-control" name="precioalquiler" id="precioalquiler" value="<?php echo $precioalquiler; ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Precio alquiler</b></span>
            <input disabled type="text" class="form-control" name="precioalquiler" id="precioalquiler" value="<?php echo $precioalquiler; ?>">
        </div>
        
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01"><b>Proveedor</b></label>
            <select class="form-select" id="idproveedor" name="idproveedor" disabled>
                <option value="<?php echo $idproveedor; ?>" selected><?php echo $vproveedor; ?></option>
                <?php foreach ($DataProveedores as $result) : ?>
                    <option value="<?php echo $result['idproveedor']; ?>"><?php echo $result['proveedor']; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
            <select class="form-select" name="estado" id="estado" disabled>
                <option value="<?php echo $estado; ?>" selected><?php echo $vestado ?></option>
                <?php if ($estado == 1) : ?>
                    <option value="2">No Disponible</option>
                <?php else : ?>
                    <option value="1">Disponible</option>
                <?php endif ?>
            </select>
        </div>
        <img src="./views/maquinas/imgmaquinas/<?php echo $img; ?>" width="280px" alt="">
    </div>
</div>