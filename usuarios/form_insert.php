<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Usuario</b></span>
  <input type="text" class="form-control" placeholder="Username" name="usuario" id="usuario">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Empleado</b></span>
  <textarea class="form-control" name="empleado" placeholder="Ingrese Nombres y Apellidos" id="empleado" oninput="this.value = this.value.toUpperCase()"></textarea>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Contraseña</b></span>
  <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="clave" id="clave" minlength="6" required>
  <div id="mensaje-password" style="color: red;"></div>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
      <i class="fas fa-eye"></i>
    </button>
  </div>
</div>

<div class="input-group mb-3">
  <span class="input-group-text"><b>Confirmar Contraseña</b></span>
  <input type="password" class="form-control" placeholder="Confirme Contraseña" name="confirmar-clave" id="confirmar-clave" minlength="6" required>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" id="togglePassword2">
      <i class="fas fa-eye"></i>
    </button>
  </div>
</div>
<div id="mensaje-confirmacion"></div>
<div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01"><b>Tipo</b></label>
  <select class="form-select" name="tipo" id="tipo">
    <option disabled selected>Seleccione Tipo</option>
    <option value="1">Administrador</option>
    <option value="2">Operador</option>
  </select>
</div>
<div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
  <select class="form-select" name="estado" id="estado">
    <option value="1" selected>Activo</option>
    <option value="2">Inactivo</option>
  </select>
</div>

<!--Validar que la contraseña contenga los caracteres y longitud solicitados-->
<script>
document.getElementById("clave").addEventListener("input", function() {
    var password = document.getElementById("clave").value;
    var mensaje = document.getElementById("mensaje-password");
    var pattern = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,}$/;

    if (!pattern.test(password)) {
        mensaje.innerHTML = "La contraseña debe contener al menos 6 caracteres, una mayúscula y un número.";
    } else {
        mensaje.innerHTML = "";
    }
});
</script>


<!-- Agregar función de ocultar y mostrar contraseña-->
<script>
document.getElementById("togglePassword").addEventListener("click", function() {
    var passwordInput = document.getElementById("clave");
    var icon = document.querySelector("#togglePassword i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});
</script>

<!--Funcion para confirmar contraseña-->

<!-- Agregar función de ocultar y mostrar contraseña opcion de confirmar-->
<script>
document.getElementById("togglePassword2").addEventListener("click", function() {
    var passwordInput2 = document.getElementById("confirmar-clave");
    var icon2 = document.querySelector("#togglePassword2 i");

    if (passwordInput2.type === "password") {
      passwordInput2.type = "text";
        icon2.classList.remove("fa-eye");
        icon2.classList.add("fa-eye-slash");
    } else {
      passwordInput2.type = "password";
        icon2.classList.remove("fa-eye-slash");
        icon2.classList.add("fa-eye");
    }
});
</script>


<!--Comparar contraseñas-->
<script>
  document.getElementById("confirmar-clave").addEventListener("input", function() {
    var passwordInput = document.getElementById("clave");
    var confirmPasswordInput = document.getElementById("confirmar-clave");
    var messageBox = document.getElementById("mensaje-confirmacion");

    var password = passwordInput.value;
    var confirmPassword = confirmPasswordInput.value;

    if (password === confirmPassword) {
      messageBox.innerHTML = "Las contraseñas coinciden";
      messageBox.style.color = "green";
    } else {
      messageBox.innerHTML = "Las contraseñas no coinciden";
      messageBox.style.color = "red";
    }
  });
</script>
