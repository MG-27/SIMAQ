<?php
  @session_start();
  include '../../models/conexion.php';
  include '../../controllers/controllersFunciones.php';
  $conn = conectar_db();
  $idestadomaquina = $_GET['idestadomaquina'];
  $sql = "SELECT * FROM estadomaquinas WHERE idestadomaquina = '$idestadomaquina'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $encargado = $row['encargado'];

  $sqlProv = "SELECT * FROM usuarios";
  $DataProveedores = $conn->query($sqlProv);
  
?>
<input type="hidden" id="idestadomaquina" name="idestadomaquina" value="<?php echo $idestadomaquina;?>">
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect01"><b>Cliente</b></label>
    <select class="form-select" id="encargado" name="encargado">
                        <option disabled selected>Seleccione Cliente</option>
                        /<?php foreach ($DataProveedores as $result) : ?>
                        <option value="<?php echo $result['empleado']; ?>"><?php echo $result['empleado']; ?></option>
                        <?php endforeach ?>
    </select>
</div>

