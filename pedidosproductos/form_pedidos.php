<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$nombre_producto = $_GET['nombreproducto'];
$sql = "SELECT * FROM productos WHERE producto = '$nombre_producto'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$producto = $row['producto'];
$detalle = $row['detalle'];
$stock = $row['stock'];
$pventa = $row['pventa'];
$pcompra = $row['pcompra'];
$minimo = $row['minimo']; // Agregado el campo de stock mínimo
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
<input type="hidden" value="<?php echo $nombre_producto; ?>" name="nombre_producto">
<input type="hidden" value="2" name="accion">

<div class="row">
  <div class="col-md-6">
    <div class="input-group mb-3">
      <span class="input-group-text"><b>Producto</b></span>
      <textarea class="form-control" name="producto" readonly><?php echo $producto; ?></textarea>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text"><b>Descripción</b></span>
      <textarea class="form-control" name="detalle" readonly><?php echo $detalle; ?></textarea>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><b>Stock</b></span>
      <input type="text" class="form-control" placeholder="Stock" name="stock" id="stock" value="<?php echo $stock; ?>">
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><b>Stock Mínimo</b></span>
      <input type="text" class="form-control" readonly name="minimo" id="minimo" value="<?php echo $minimo; ?>">
    </div>
    <input type="hidden" value="<?php echo $nombre_producto; ?>" name="nombre_producto">
  </div>
  <div class="col-md-6">
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Categoria</b></label>
      <input type="text" class="form-control" readonly value="<?php echo $vcategoria; ?>">
    </div>
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Proveedor</b></label>
      <input type="text" class="form-control" readonly value="<?php echo $vproveedor; ?>">
    </div>
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
      <input type="text" class="form-control" readonly value="<?php echo $vestado ?>">
    </div>
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupFile01">Imagen</label>
      <input type="file" class="form-control" id="imagenProd" name="imagenProd">
    </div>
    <div class="row">
      <div class="col-md-6">
        <img src="./views/productos/imgproductos/<?php echo $img; ?>" width="180px" alt="">
      </div>
      <div class="col-md-6">
        <div id="imagenPrevisualizacion"></div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#imagenProd').change(function() {
      var archivo = this.files[0];
      if (archivo) {
        var lector = new FileReader();
        lector.onload = function(evento) {
          $('#imagenPrevisualizacion').html('<img src="' + evento.target.result + '" width=\'200px\'>');
        };
        lector.readAsDataURL(archivo);
      }
    });
  });
</script>
