<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$sqlProv = "SELECT * FROM proveedores";
$DataProveedores = $conn->query($sqlProv);

?>
<input type="hidden" value="1" id="accion">
<div class="row">
  <div class="col-md-6">
        <div class="input-group mb-3">
        <span class="input-group-text"><b>Máquina</b></span>
        <textarea class="form-control" name="nombremaquina" placeholder="Ingrese Nombres de máquina" id="nombremaquina"></textarea>
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text"><b>Descripción</b></span>
        <textarea class="form-control" name="descripcion" placeholder="Descripción de Producto" id="descripcion"></textarea>
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><b>Stock</b></span>
        <input type="text" class="form-control" placeholder="Stock" name="cantidadstock" id="cantidadstock">
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><b>Stock Minimo</b></span>
        <input type="text" class="form-control" name="minimo" id="minimo">
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><b>Precio Compra</b></span>
        <input type="text" class="form-control" name="preciocompra" id="preciocompra">
        </div>
  </div>
  <div class="col-md-6">
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><b>Precio Alquiler</b></span>
      <input type="text" class="form-control" name="precioalquiler" id="precioalquiler" readonly>
    </div>
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Proveedor</b></label>
      <select class="form-select" id="idproveedor" name="idproveedor">
        <option disabled selected>Seleccione Proveedor</option>
        <?php foreach ($DataProveedores as $result) : ?>
          <option value="<?php echo $result['idproveedor']; ?>"><?php echo $result['proveedor']; ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
      <select class="form-select" name="estado" id="estado">
        <option value="1" selected>Activo</option>
        <option value="2">Inactivo</option>
      </select>
    </div>
    <div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupFile01">Imagen</label>
      <input type="file" class="form-control" id="imagenMaq" name="imagenMaq" >
    </div>
    <div id="imagenPrevisualizacion"></div>
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
