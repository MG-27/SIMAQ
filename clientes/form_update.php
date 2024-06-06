<?php
  @session_start();
  include '../../models/conexion.php';
  include '../../controllers/controllersFunciones.php';
  $conn = conectar_db();
  $idcliente = $_GET['idcliente'];
  $sql = "SELECT * FROM clientes WHERE idcliente = '$idcliente'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $nombrecliente = $row['nombrecliente'];
  $dui = $row['dui'];
  $telefono = $row['telefono'];
  $email = $row['email'];
  $direccion = $row['direccion'];
  $estado = $row['estado'];
  $vestado = ($estado == 1)? 'Activo':'Inactivo';
  
?>
<input type="hidden" id="idcliente" name="idcliente" value="<?php echo $idcliente;?>">
<div class="input-group mb-3">
  <span class="input-group-text"><b>Cliente</b></span>
  <textarea class="form-control" name="nombrecliente" placeholder="Ingrese nombre del cliente" id="nombrecliente"><?php echo $nombrecliente;?></textarea>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>DUI</b></span>
  <input type="text" class="form-control" placeholder="########-#" name="dui" id="dui" pattern="[0-9]{8}-[0-9]{1}" title="Ingrese un número de DUI válido (########-#)" maxlength="10" value="<?php echo $dui;?>">
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

<!-- Validar telefono que solo sean numeros-->
<script>
  // Validar DUI que solo sean números y formatearlo con un guión
  document.getElementById("dui").addEventListener("input", function(event) {
    // esta función permite que no se dupliquen guiones
    var dui = this.value.replace(/-/g, "");
    
    // esta función escribe el guión en automático
    if (dui.length >= 8) {
      dui = dui.slice(0, 8) + "-" + dui.slice(8);
    }
    
    // Actualizar el valor del input
    this.value = dui;
  });
</script>