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
$preciocompra = $row['preciocompra'];
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
      <textarea class="form-control" name="nombremaquina" placeholder="Ingrese Nombres de maquinaria" id="nombremaquina"><?php echo $nombremaquina; ?></textarea>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text"><b>Descripción</b></span>
      <textarea class="form-control" name="descripcion" placeholder="Descripción de Producto" id="descripcion"><?php echo $descripcion; ?></textarea>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><b>cantidadstock</b></span>
      <input type="text" class="form-control" placeholder="cantidadstock" name="cantidadstock" id="cantidadstock" value="<?php echo $cantidadstock; ?>">
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><b>Stock Minimo</b></span>
      <input type="text" class="form-control" name="minimo" id="minimo" value="<?php echo $minimo; ?>">
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><b>Precio Compra</b></span>
      <input type="text" class="form-control" name="preciocompra" id="preciocompra" value="<?php echo $preciocompra; ?>">
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><b>Precio Alquiler</b></span>
      <input type="text" class="form-control" name="precioalquiler" id="precioalquiler" value="<?php echo $precioalquiler; ?>" readonly>
    </div>
  </div>
  <div class="col-md-6">
    
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Proveedor</b></label>
      <select class="form-select" id="idproveedor" name="idproveedor">
        <option value="<?php echo $idproveedor; ?>" selected><?php echo $vproveedor; ?></option>
        <?php foreach ($DataProveedores as $result) : ?>
          <option value="<?php echo $result['idproveedor']; ?>"><?php echo $result['proveedor']; ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
      <select class="form-select" name="estado" id="estado">
        <option value="<?php echo $estado; ?>" selected><?php echo $vestado ?></option>
        <?php if ($estado == 1) : ?>
          <option value="2">No Disponible</option>
        <?php else : ?>
          <option value="1">Disponible</option>
        <?php endif ?>
      </select>
    </div>
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupFile01">Imagen</label>
      <input type="file" class="form-control" id="imagenMaq" name="imagenMaq">
    </div>
    <dov class="row">
      <div class="col-md-6">
        <img src="./views/maquinas/imgmaquinas/<?php echo $img; ?>" width="180px" alt="">
      </div>
      <div class="col-md-6">
        <div id="imagenPrevisualizacion"></div>
      </div>
    </dov>

  </div>
</div>
<script>
  $(document).ready(function() {
    $('#imagenMaq').change(function() {
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

<!--CALCULAR EL PRECIO DEL ALQUILER DE FORMA AUTOMATICA-->
<script>
    //calcular el precio de alquiler
    function calcularPrecioAlquiler() {
        var precioCompra = parseFloat(document.getElementById("preciocompra").value);

        // Calcular el impuesto del IVA
        var iva = precioCompra * 0.13;

        // Sumar el IVA al precio de compra para obtener el costo total
        var costoTotal = precioCompra + iva;

        // Agregando otros cargos adicionales
        var tarifaSeguro = 50; // se puede agregar una tarifa de seguro de maquinaria
        var tarifaEntrega = 100; // se puede agregar la tarifa de entrega del producto

        // Sumar los cargos adicionales al costo total
        costoTotal += tarifaSeguro + tarifaEntrega;

        // Calcular la ganancia (supongamos 20%) este valor va variar de acuerdo al que decida la empresa
        var ganancia = costoTotal * 0.20;

        // Sumar la ganancia al costo total para obtener el precio de alquiler
        var precioAlquiler = costoTotal + ganancia;

        // Mostrar el precio de alquiler en el campo de entrada correspondiente
        document.getElementById("precioalquiler").value = precioAlquiler.toFixed(2);
    }

    // permite mostrar y  calcular automáticamente el precio de alquiler en el campo de precio alquiler
    document.getElementById("preciocompra").addEventListener("change", calcularPrecioAlquiler);
</script>