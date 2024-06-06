<div class="input-group mb-3">
  <span class="input-group-text"><b>Proveedor</b></span>
  <textarea class="form-control" name="proveedor" placeholder="Ingrese Proveedor" id="proveedor"></textarea>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Teléfono</b></span>
  <input type="text" class="form-control" placeholder="####-####" name="telefono" id="telefono" pattern="[0-9]{4}-[0-9]{4}" title="Ingrese un número de teléfono válido (####-####)" maxlength="9" required>
</div>
<div class="input-group mb-3">
    <span class="input-group-text"><b>Email</b></span>
    <input type="text" class="form-control" placeholder="nombre@correo.com" id="email">
    
</div>

<div class="input-group mb-3">
  <span class="input-group-text"><b>Dirección</b></span>
  <textarea class="form-control" name="direccion" placeholder="Ingrese Dirección" id="direccion"></textarea>
</div>

<div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
  <select class="form-select" name="estado" id="estado">
    <option value="1" selected>Activo</option>
    <option value="2">Inactivo</option>
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

<!--Validar campo correo -->
<script>
// Obtener el input del correo electrónico
var emailInput = document.getElementById("email");

// Agregar el evento de foco al input
emailInput.addEventListener("focus", function() {
    // Si el campo está vacío, añadir el símbolo "@"
    if (emailInput.value === "") {
        emailInput.value = "@";
    }
});

// Agregar el evento de cambio al input
emailInput.addEventListener("input", function() {
    // Si el campo está vacío, añadir el símbolo "@" de nuevo
    if (emailInput.value === "") {
        emailInput.value = "@";
    }
});

// Agregar el evento de blur (cuando se pierde el foco) al input
emailInput.addEventListener("blur", function() {
    // Si el campo está vacío, restaurar el valor predeterminado
    if (emailInput.value === "@") {
        emailInput.value = "";
    }
});
</script>
<!-- -->
<!-- -->
<!-- -->