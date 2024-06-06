<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$sql = "SELECT * FROM clientes";

$result = $conn->query($sql);
$cont = 0;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="./public/css/botonatras.css">
<a href="./index.php" class="btn botonatras">
    <i class="fa-solid fa-reply"></i>Atrás
</a>
<div>
    <p style="text-align: center;"><b>Panel Clientes</b></p>
</div>
<div class="table-responsive" id="DataPanelClientes">
    <a href="" class="btn text-white" style="background-color: #031A58;" id="BtnNewCliente"><i class="fa-solid fa-circle-plus"></i></a>
    <a href="" class="btn text-white" style="float: right;background-color: #031A58;" id="Reload"><i class="fa-solid fa-rotate"></i></a>
    <hr>
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Cliente</th>
                    <th>Identificación</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    $query = "SELECT COUNT(nombrecliente) as contId FROM alquiler WHERE nombrecliente='" . $data['nombrecliente'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdProv = $row2['contId'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['nombrecliente']; ?></td>
                        <td><?php echo $data['dui']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo $data['direccion']; ?></td>
                        <td><?php echo ($data['estado'] == 1) ? '<b style="color:green;">Activo</b>' : '<b style="color:red;">Inactivo</b>'; ?></td>
                        <td>
                            <a href="" class="btn text-white BtnUpdateCliente" idcliente="<?php echo $data['idcliente']; ?>" style="background-color: #078E10;"><i class="fa-regular fa-pen-to-square"></i></a>
                        </td>
                        <td>
                            <?php if ($contIdProv == 0) : ?>
                                <a href="" class="btn text-white BtnDeleteUser" idcliente="<?php echo $data['idcliente']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-trash-can"></i></a>
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
            <b>No se encuentran datos...</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>

<script>
    $(document).ready(function() {
        //
        $("#BtnNewCliente").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Cliente';
            $("#DataModalPrincipal").load("./views/clientes/form_insert.php");
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });
        //
        $(".BtnUpdateCliente").click(function() {
            let idcliente = $(this).attr("idcliente");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Modificar Cliente';
            $("#DataModalPrincipal").load("./views/clientes/form_update.php?idcliente=" + idcliente);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {
            if ($('#nombrecliente').val() === '' || $('#dui').val() === ''|| $('#telefono').val() === '' || $('#email').val() === '' || $('#direccion').val() == null || $('#estado').val() === '' || $('#estado').val() == null) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let nombrecliente, dui,telefono, email, estado, direccion;
            nombrecliente = $('#nombrecliente').val();
            dui = $('#dui').val();
            telefono = $('#telefono').val();
            email = $('#email').val();
            estado = $('#estado').val();
            direccion = $('#direccion').val();

            var formData = {

                nombrecliente: nombrecliente,
                dui: dui,
                telefono: telefono,
                email: email,
                estado: estado,
                direccion: direccion
            };
            $.ajax({
                type: 'POST',
                url: './views/clientes/insert.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#nombrecliente').val('');
                    $('#dui').val('');
                    $('#telefono').val('');
                    $('#email').val('');
                    $('#estado').val('');
                    $('#direccion').val('');
                    $("#DataPanelClientes").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#nombrecliente').val() === '' || $('#dui').val() === ''|| $('#telefono').val() === '' || $('#email').val() === '' || $('#direccion').val() == null || $('#estado').val() === '' || $('#estado').val() == null) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let idcliente, nombrecliente, dui, telefono, email, estado, direccion;
            idcliente = $('#idcliente').val();
            nombrecliente = $('#nombrecliente').val();
            dui = $('#dui').val();
            telefono = $('#telefono').val();
            email = $('#email').val();
            estado = $('#estado').val();
            direccion = $('#direccion').val();

            var formData = {
                idcliente: idcliente,
                nombrecliente: nombrecliente,
                dui: dui,
                telefono: telefono,
                email: email,
                estado: estado,
                direccion: direccion
            };
            $.ajax({
                type: 'POST',
                url: './views/clientes/update.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#nombrecliente').val('');
                    $('#dui').val('');
                    $('#telefono').val('');
                    $('#email').val('');
                    $('#estado').val('');
                    $('#direccion').val('');
                    $("#DataPanelClientes").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
                // Proceso Delete
                $(document).ready(function() {
            $('.BtnDeleteUser').click(function() {
                let idcliente = $(this).attr('idcliente');

                Swal.fire({
                    title: '¿Desea eliminar el cliente?',
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
                            url: './views/clientes/del.php',
                            data: { idcliente: idcliente },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'El cliente ha sido eliminado.',
                                    'success'
                                );
                                $("#DataPanelClientes").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al eliminar el cliente.',
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
        $("#Reload").click(function() {
            $("#sub-data").load("./views/clientes/principal.php");
            return false;
        });
    });
</script>