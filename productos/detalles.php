<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$idproducto = $_GET['idproducto'];
$sql = "SELECT * FROM productos WHERE idproducto = '$idproducto'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$producto = $row['producto'];
$detalle = $row['detalle'];
$stock = $row['stock'];
$pventa = $row['pventa'];
$pcompra = $row['pcompra'];
$minimo = $row['minimo'];
$img = $row['img'];
$idproveedor = $row['idproveedor'];
$sqlProveedor = $conn->query("SELECT proveedor FROM proveedores WHERE idproveedor = '$idproveedor'");
$rowPv = $sqlProveedor->fetch_assoc();
$vproveedor = $rowPv['proveedor'];

$idcategoria = $row['idcategoria'];
$sqlCategoria = $conn->query("SELECT categoria FROM categorias WHERE idcategoria = '$idcategoria'");
$rowC = $sqlCategoria->fetch_assoc();
$vcategoria = $rowC['categoria'];

$estado = $row['estado'];
$vestado = ($estado == 1) ? 'Disponible' : 'No Disponible';

$sqlCate = "SELECT * FROM categorias WHERE idcategoria != '$idcategoria'";
$DataCategorias = $conn->query($sqlCate);

$sqlProv = "SELECT * FROM proveedores WHERE idproveedor != '$idproveedor'";
$DataProveedores = $conn->query($sqlProv);

?>
<input type="hidden" value="2" id="accion">
<input type="hidden" value="<?php echo $idproducto; ?>" name="idproducto">
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Producto</b></span>
            <textarea disabled class="form-control" name="producto" placeholder="Ingrese Nombres de Producto" id="producto"><?php echo $producto; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Descripción</b></span>
            <textarea disabled class="form-control" style="height: 200px;" name="detalle" placeholder="Descripción de Producto" id="detalle"><?php echo $detalle; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Stock</b></span>
            <input disabled type="text" class="form-control" placeholder="Stock" name="stock" id="stock" value="<?php echo $stock; ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Stock Minimo</b></span>
            <input disabled type="text" class="form-control" name="minimo" id="minimo" value="<?php echo $minimo; ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Precio Compra</b></span>
            <input disabled type="text" class="form-control" name="pcompra" id="pcompra" value="<?php echo $pcompra; ?>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Precio Venta</b></span>
            <input disabled type="text" class="form-control" name="pventa" id="pventa" value="<?php echo $pventa; ?>">
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01"><b>Categoria</b></label>
            <select class="form-select" id="idcategoria" name="idcategoria" disabled>
                <option value="<?php echo $idcategoria; ?>" selected><?php echo $vcategoria; ?></option>
                <?php foreach ($DataCategorias as $result) : ?>
                    <option value="<?php echo $result['idcategoria']; ?>"><?php echo $result['categoria']; ?></option>
                <?php endforeach ?>
            </select>
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
        <img src="./views/productos/imgproductos/<?php echo $img; ?>" width="280px" alt="">
    </div>
</div>