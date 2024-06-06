<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$tipo = $_SESSION['tipo'];
$sql = "SELECT * FROM maquinas";

$result = $conn->query($sql);
$cont = 0;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="./public/css/botonatras.css">

<a href="./index.php" class="btn botonatras">
    <i class="fa-solid fa-reply"></i>Atrás
</a>
<div>
    <p style="text-align: center;"><b>Panel Maquinarias</b></p>
</div>
<div class="table-responsive" id="DataPanelMaquinas">
    <a href="" class="btn text-white" style="background-color: #031A58;" id="BtnNewMaq"><i class="fa-solid fa-circle-plus"></i></a>
    <a href="#" class="btn text-white" style="float: right;background-color: #031A58;" id="Reload"><i class="fa-solid fa-rotate"></i></a>
    <hr>
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Máquina</th>
                    <th>Imagen<br>Maquinaria</th>
                    <th>Stock</th>
                    <th>Stock <br>Alerta</th>
                    <th>Precio <br>Compra</th>
                    <th>Precio <br>Alquiler</th>
                    <th>Estado</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    $query = "SELECT COUNT(idmaquina) as contIdMaquina FROM detallealquiler WHERE idmaquina='" . $data['idmaquina'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdUser = $row2['contIdMaquina'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['nombremaquina']; ?></td>
                        <td>
                            <img src="./views/maquinas/imgmaquinas/<?php echo $data['img']; ?>" width="80px" alt="">
                        </td>
                        <td><?php echo $data['cantidadstock']; ?></td>
                        <td><?php echo $data['minimo']; ?></td>
                        <td>$<?php echo $data['preciocompra']; ?></td>
                        <td>$<?php echo $data['precioalquiler']; ?></td>
                        <td>
                            <?php
                            echo ($data['estado'] == 1) ? '<b style="color:green;">Disponible</b>' : '<b style="color:red;">No Disponible</b>';
                            ?>
                        </td>

                        <td>
                            <a href="" class="btn text-white BtnDetalleMaquina" idmaquina="<?php echo $data['idmaquina']; ?>" style="background-color: #078E10;"><i class="fa-solid fa-list-check"></i></a>
                        </td>
                        <td>
                            <?php if ($tipo == 1) : ?>
                                <a href="" class="btn text-white BtnUpdateMaq" idmaquina="<?php echo $data['idmaquina']; ?>" style="background-color: #031A58;"><i class="fa-regular fa-pen-to-square"></i></a>
                            <?php else : ?>
                                <a href="" class="btn text-white " idmaquina="<?php echo $data['idmaquina']; ?>" style="background-color: #031A58;background-color: #ccc; cursor: not-allowed;" onclick="return false;"><i class="fa-regular fa-pen-to-square"></i></a>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if ($contIdUser == 0 && $tipo == 1) : ?>
                                <a href="" class="btn text-white BtnDeleteMaq" idmaquina="<?php echo $data['idmaquina']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-trash-can"></i></a>
                            <?php else : ?>
                                <a href="" class="btn text-white" style="background-color: #031A58;background-color: #ccc; cursor: not-allowed;" onclick="return false;"><i class="fa-solid fa-trash-can"></i></a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-danger">
            <b>No se encuentran datos........</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>

<script>
    $(document).ready(function() {
        $(".BtnDetalleMaquina").click(function() {
            let idmaquina = $(this).attr("idmaquina");
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModalProd").innerHTML = 'Detalles de Maquinaria';
            $("#DataModalPrincipalProd").load("./views/maquinas/detalles.php?idmaquina=" + idmaquina);
            $('#ProcesoBotonModalProd').css('display', 'none');
            $('#ProcesoBotonModalProd2').css('display', 'none');
            document.getElementById("TituloBotonModalProd3").innerHTML = 'Cerrar';
            return false;
        });
        //
        $("#BtnNewMaq").click(function() {
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModalProd").innerHTML = 'Registrar Maquinaria';
            $("#DataModalPrincipalProd").load("./views/maquinas/form_insert.php");
            $('#ProcesoBotonModalProd').css('display', 'block');
            $('#ProcesoBotonModalProd2').css('display', 'none');
            document.getElementById("TituloBotonModalProd").innerHTML = 'Guardar';
            return false;
        });
        //
        $(".BtnUpdateMaq").click(function() {
            let idmaquina = $(this).attr("idmaquina");
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModalProd").innerHTML = 'Modificar Información de Maquinaria';
            $("#DataModalPrincipalProd").load("./views/maquinas/form_update.php?idmaquina=" + idmaquina);
            $('#ProcesoBotonModalProd').css('display', 'none');
            $('#ProcesoBotonModalProd2').css('display', 'block');
            document.getElementById("TituloBotonModalProd2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Insert | Update 
        $("#AccionProductos").on('submit', function(e) {
            let accion = $('#accion').val();
            var formData = new FormData(document.getElementById("AccionProductos"));
            formData.append("dato", "valor");
            if ($('#nombremaquina').val() === '' || $('#descripcion').val() === '' || $('#cantidadStock').val() === '' || $('#estado').val() === '' ||  $('#img').val() === '' || $('#idproveedor').val() === '' ) {
                alert('Por favor completa todos los campos.');
                return false;
            } else {
                if (accion == 1) {
                    $.ajax({
                            url: "./views/maquinas/insert.php",
                            type: "POST",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false
                        })
                        .done(function(result) {
                            $("#ModalPrincipalProd").modal("hide");
                            $("#DataPanelMaquinas").html(result);
                        });
                } else {
                    $.ajax({
                            url: "./views/maquinas/update.php",
                            type: "POST",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false
                        })
                        .done(function(result) {
                            $("#ModalPrincipalProd").modal("hide");
                            $("#DataPanelMaquinas").html(result);
                        });
                }
            }
            e.preventDefault();
        });
        // Proceso Delete
        $(document).ready(function() {
            $('.BtnDeleteMaq').click(function() {
                let idmaquina = $(this).attr('idmaquina');

                Swal.fire({
                    title: '¿Desea eliminar la maquinaria?',
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: './views/maquinas/del.php',
                            data: { idmaquina: idmaquina },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'La maquinaria ha sido eliminada.',
                                    'success'
                                );
                                $("#DataPanelMaquinas").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al eliminar la maquinaria.',
                                    'error'
                                );
                            }
                        });
                    } else {
                        Swal.fire(
                            'Cancelado',
                            'El proceso ha sido cancelado.',
                            'error'
                        );
                    }
                });

                return false;
            });
        });

        //
        $('#Reload').click(function(event) {
            event.preventDefault(); // Previene el comportamiento por defecto del enlace.

            Swal.fire({
                title: '¿Está seguro?',
                text: "¡Se recargará la página!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, recargar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload(); // Recarga la página actual si el usuario confirma.
                }
            });
        });
    });
</script>