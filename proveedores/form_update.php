<?php
  @session_start();
  include '../../models/conexion.php';
  include '../../controllers/controllersFunciones.php';
  $conn = conectar_db();
  $idproveedor = $_GET['idproveedor'];
  $sql = "SELECT * FROM proveedores WHERE idproveedor = '$idproveedor'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $proveedor = $row['proveedor'];
  $telefono = $row['telefono'];
  $email = $row['email'];
  $direccion = $row['direccion'];
  $estado = $row['estado'];
  $vestado = ($estado == 1)? 'Activo':'Inactivo';
  
?>
<input type="hidden" id="idproveedor" name="idproveedor" value="<?php echo $idproveedor;?>">
<div class="input-group mb-3">
  <span class="input-group-text"><b>Proveedor</b></span>
  <textarea class="form-control" name="proveedor" placeholder="Ingrese Proveedor" id="proveedor"><?php echo $proveedor;?></textarea>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Teléfono</b></span>
  <input type="text" class="form-control" placeholder="####-####" pattern="[0-9]{4}-[0-9]{4}" maxlength="9" name="telefono" id="telefono" value="<?php echo $telefono;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Email</b></span>
  <textarea class="form-control" name="email" placeholder="Ingrese Email" id="email"><?php echo $email;?></textarea>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Dirección</b></span>
  <textarea class="form-control" name="direccion" placeholder="Ingrese Dirección" id="direccion"><?php echo $direccion;?></textarea>
</div>
<div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
  <select class="form-select" name="estado" id="estado">
    <option value="<?php echo $estado;?>" selected><?php echo $vestado?></option>
    <?php if($estado == 1):?>
      <option value="2">Inactivo</option>
    <?php else:?>
      <option value="1">Activo</option>
    <?php endif?>
  </select>
</div>

<!-- Validar telefono que solo sean numeros-->
<script>
  document.getElementById("telefono").addEventListener("input", function(event) {
    // esta función permite que no se dupliquen guiones
    var telefono = this.value.replace(/-/g, "");
    
    // esta función escribe el guión en automatico
    if (telefono.length >= 4) {
      telefono = telefono.slice(0, 4) + "-" + telefono.slice(4);
    }
    
    // Actualizar el valor del input
    this.value = telefono;
  });
</script>