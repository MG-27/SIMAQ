<!--<link rel="stylesheet" href="./public/css/botonsalir.css">
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #191970;" >
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="./index.php">SIMAQ</a>
    <button class="navbar-toggler text-white" style="color: red;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon  bg-light"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page"  href="./index.php">Inicio</a>
        </li>
      </ul>
      <form action="./index.php" class="d-flex" method="POST">
        <input type="hidden" value="1" name="off">
        <button class="btn botonsalir" class="btn btn-outline-danger btn-sm text-white">
        <i class="fa-solid fa-right-from-bracket"></i> Salir
        </button>        
      </form>
      <form id="logoutForm" action="./index.php" class="d-flex" method="POST">
          <input type="hidden" value="1" name="off">
          <button id="logoutButton" class="btn botonsalir" class="btn btn-outline-danger btn-sm text-white">
              <i class="fa-solid fa-right-from-bracket"></i> Salir
          </button>        
      </form>
    </div>
  </div>
</nav>-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <!-- Incluye tus archivos CSS y JS -->
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/botonsalir.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="./public/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #191970;">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="./index.php">SIMAQ</a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon bg-light"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="./index.php">Inicio</a>
                    </li>
                </ul>
                <form id="logoutForm" class="d-flex" method="POST">
                    <input type="hidden" value="1" name="off">
                    <button id="logoutButton" class="btn botonsalir" type="button">
                        <i class="fa-solid fa-right-from-bracket"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <script>
        $(document).ready(function() {
            $('#logoutButton').click(function(event) {
                event.preventDefault(); // Evita cualquier acción por defecto

                Swal.fire({
                    title: '¿Desea cerrar sesión?',
                    text: "¡Se cerrará tu sesión actual!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './views/logout.php'; // Ajusta la ruta si es necesario
                    } else {
                        Swal.fire(
                            'Cancelado',
                            'Tu sesión permanece activa',
                            'info'
                        );
                    }
                });
            });
        });
    </script>
</body>
</html>
