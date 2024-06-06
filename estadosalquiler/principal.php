<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$tipo = $_SESSION['tipo'];
$sql = "SELECT d.*, m.nombremaquina
        FROM estadomaquinas d
        INNER JOIN maquinas m ON d.idmaquina = m.idmaquina";

$result = $conn->query($sql);
$cont = 0;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="./public/css/botonatras.css">
<a href="./index.php" class="btn botonatras">
    <i class="fa-solid fa-reply"></i>Atrás
</a>
<div>
    <p style="text-align: center;"><b>Detalle  estado de maquinaria en alquiler</b></p>
</div>
<div class="table-responsive" id="DataPanelAlquiler">
    <hr>
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Nombre de la Máquina</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Recibio</th>
                    <th>Acciones</th>
                    <th>Cambiar estado</th>
                    <!-- Agrega más columnas según los campos de la tabla detallealquiler -->
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['nombremaquina']; ?></td>
                        <td><?php echo $data['cantidad']; ?></td>
                        <td><?php echo $data['total']; ?></td>
                        <td>
                            <?php
                            echo ($data['estado'] == 1) ? '<b style="color:red;">En uso</b>' : '<b style="color:green;">Devuelta</b>';
                            ?>
                        </td>
                        <td><?php echo $data['encargado']; ?></td>

                        <td>
                            <?php if ($data['estado'] == 1) : ?>
                                <a href="" class="btn text-white BtnEncargado" idestadomaquina="<?php echo $data['idestadomaquina']; ?>" style="background-color: #078E10;"><i class="fa-regular fa-pen-to-square"></i>
                            <?php else : ?>
                                <a disabled href="" class="btn text-white BtnEncargado" idestadomaquina="<?php echo $data['idestadomaquina']; ?>" style="background-color: #ccc; cursor: not-allowed;" onclick="return false;" ><i class="fa-regular fa-pen-to-square"></i>
                            <?php endif ?>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm change-status" 
                                    data-id="<?php echo $data['idestadomaquina']; ?>" 
                                    data-status="<?php echo $data['estado']; ?>"
                                    <?php if ($data['estado'] == 0) echo 'style="background-color: #ccc; cursor: not-allowed;" disabled'; ?>><i class="fa-solid fa-right-left"></i> 
                                <?php echo ($data['estado'] == 1) ? 'Finalizar Uso' : 'Maquinaria retornada'; ?>
                            </button>
                        </td>

                        <!-- Agrega más columnas según los campos de la tabla detallealquiler -->
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-danger">
            <b>No se encuentran datos</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>

<script>
$(".change-status").click(function() {
    let idestadomaquina = $(this).data("id");
    let estado = $(this).data("status");
    console.log("idestadomaquina:", idestadomaquina);
    console.log("estado:", estado);

    $.ajax({
        url: "./views/estadosalquiler/cambiarestado.php",
        type: "POST",
        data: {
            idestadomaquina: idestadomaquina,
            estado: estado
        },
        success: function(response) {
            $("#DataPanelAlquiler").html(response);
            // Manejar la respuesta según sea necesario
            //alert(response);
            // Si necesitas actualizar la página o hacer algún otro tipo de acción después de cambiar el estado, puedes hacerlo aquí.
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
            //alert("Error al cambiar el estado de la maquinaria");
        }
    });


});

</script>

<script>
    $(document).ready(function() {
        
        //
        $(".BtnEncargado").click(function() {
            let idestadomaquina = $(this).attr("idestadomaquina");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Actualizar recepción de maquinaria';
            $("#DataModalPrincipal").load("./views/estadosalquiler/form_update.php?idestadomaquina=" + idestadomaquina);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        
        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#encargado').val() === '' ) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let idestadomaquina, encargado;
            idestadomaquina = $('#idestadomaquina').val();
            encargado = $('#encargado').val();
            var formData = {
                idestadomaquina: idestadomaquina,
                encargado: encargado,
            };
            $.ajax({
                type: 'POST',
                url: './views/estadosalquiler/update.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#encargado').val('');
                    $("#DataPanelAlquiler").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        
    });
</script>

<script>
    $(document).ready(function() {
    // Deshabilitar los botones del encargado cuando el estado de la máquina sea 0
    $(".BtnEncargado").each(function() {
        let estado = $(this).data("estado");
        if (estado == 0) {
            $(this).prop("disabled", true);
        }
    });
});

</script>








