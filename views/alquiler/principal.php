<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$ventasEstado0 = "SELECT COUNT(*) AS tventas FROM alquiler WHERE estado=0 AND idusuario='$idusuario'";
$result = $conn->query($ventasEstado0);
$row = $result->fetch_assoc();
$tventas = $row['tventas'];

$sqlProv = "SELECT * FROM clientes";
$DataProveedores = $conn->query($sqlProv);
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="./public/css/botonatras.css">

<a href="./index.php" class="btn botonatras">
    <i class="fa-solid fa-reply"></i>Atrás
</a>
<style>
    .bloqueado {
        pointer-events: none;
        opacity: 0.5;
        /* Puedes ajustar la opacidad para hacer el botón más transparente si lo deseas */
        cursor: not-allowed;
        /* Cambia el cursor para indicar que el botón no está disponible */
    }
</style>
<div>
    <p style="text-align: center;"><b>Panel Alquiler</b></p>
</div>
<div class="row">
    <div class="col-md-3" style="margin-bottom: 5px;">
        <div class="card">
            <div class="card-header">
                <b>Registra Alquiler</b>
                <?php if ($tventas == 0) : ?>
                    <a href="" style="float: right;" class="btn btn-warning bloqueado" disabled><i class="fa-solid fa-cart-shopping"></i> <?php echo $tventas; ?></a>
                <?php else : ?>
                    <a href="" style="float: right;" class="btn btn-warning" id="BtnPreventa"><i class="fa-solid fa-cart-shopping"></i> <?php echo $tventas; ?></a>
                <?php endif ?>
            </div>
            <div class="card-body">
            
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01"><b>Cliente</b></label>
                    <select class="form-select" id="nombrecliente" name="nombrecliente">
                        <option disabled selected>Seleccione Cliente</option>
                        /<?php foreach ($DataProveedores as $result) : ?>
                        <option value="<?php echo $result['nombrecliente']; ?>"><?php echo $result['nombrecliente']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="fecha_inicio"><b>Fecha de Inicio</b></label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="fecha_fin"><b>Fecha de Finalización</b></label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="tipo_alquiler"><b>Tipo de Alquiler</b></label>
                    <select class="form-select" id="tipo_alquiler" name="tipo_alquiler">
                        <option disabled selected>Seleccione Tipo de Alquiler</option>
                        <option value="Diario">Diario</option>
                        <option value="Mensual">Mensual</option>
                        <option value="Anual">Anual</option>
                    </select>
                </div>
                <a class="btn btn-primary" id="BtnReg-Venta"><b>Procesar</b></a>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <b>Resultado</b>
            </div>
            <div class="card-body" id="DataVentas">
                <?php if (isset($_GET['idalquiler'])) : ?>
                    <script>
                        $(document).ready(function() {
                            let idalquiler = '<?php echo $_GET['idalquiler'];?>';
                            $("#ModalPrincipal2").modal("show");
                            $('#DataEfectosModal2').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
                            document.getElementById("DataTituloModal2").innerHTML = 'Comprobante de Alquiler';
                            $("#DataModalPrincipal2").load("./views/alquiler/comprobante.php?idalquiler=" + idalquiler);
                            return false;
                        });
                    </script>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#BtnReg-Venta").click(function() {
            if ($('#nombrecliente').val() === '') {
                alert('Por favor ingrese datos del nombrecliente');
                return;
            }
            let nombrecliente;
            nombrecliente = $('#nombrecliente').val();
            let fecha_inicio;
            fecha_inicio = $('#fecha_inicio').val();
            let fecha_fin;
            fecha_fin = $('#fecha_fin').val();
            let tipo_alquiler;
            tipo_alquiler = $('#tipo_alquiler').val();

            var formData = {
                nombrecliente: nombrecliente,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                tipo_alquiler: tipo_alquiler
            };
            $.ajax({
                type: 'POST',
                url: './views/alquiler/regalquiler.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $('#nombrecliente').val('');
                    $('#fecha_inicio').val('');
                    $('#fecha_fin').val('');
                    $('#tipo_alquiler').val('');
                    $("#DataVentas").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });

        $("#BtnPreventa").click(function() {
            $("#DataVentas").load("./views/alquiler/prealquiler.php");
            return false;
        });
    });
</script>
