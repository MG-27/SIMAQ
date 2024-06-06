<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$sql = "SELECT * FROM usuarios";

$result = $conn->query($sql);
$cont = 0;

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="./public/css/botonatras.css">

<a href="./index.php" class="btn botonatras">
    <i class="fa-solid fa-reply"></i>Atrás
</a>
<div>
    <p style="text-align: center;"><b>Panel Usuarios</b></p>
</div>
<div class="table-responsive" id="DataPanelUsuarios">
    <a href="" class="btn text-white" style="background-color: #031A58;" id="BtnNewUser"><i class="fa-solid fa-user-plus"></i></a>
    <hr>
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 80%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Usuario</th>
                    <th>Empleado</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    $query = "SELECT COUNT(idusuario) as contId FROM ventas WHERE idusuario='" . $data['idusuario'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdUser = $row2['contId'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['usuario']; ?></td>
                        <td><?php echo $data['empleado']; ?></td>
                        <td><?php echo ($data['tipo'] == 1) ? 'Adminsitrador' : 'Operador'; ?></td>
                        <td><?php echo ($data['estado'] == 1) ? '<b style="color:green;">Activo</b>' : '<b style="color:red;">Inactivo</b>'; ?></td>
                        <!-- td>
                        <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-key"></i></a>
                    </td -->
                        <td>
                            <a href="" class="btn text-white BtnUpdateUser" idusuario="<?php echo $data['idusuario']; ?>" style="background-color: #078E10;"><i class="fa-solid fa-user-pen"></i></a>
                        </td>
                        <!--td>
                        <?php //if ($data['estado'] == 1) : 
                        ?>
                            <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-user-large-slash"></i></a>
                        <?php //else : 
                        ?>
                            <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-user-check"></i></a>
                        <?php //endif 
                        ?>
                    </td -->
                        <td>
                            <?php if ($contIdUser == 0) : ?>
                                <a href="" class="btn text-white BtnDeleteUser" idusuario="<?php echo $data['idusuario']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-user-xmark"></i></a>
                            <?php else : ?>
                                <a href="" class="btn text-white" style="background-color: #031A58;background-color: #ccc; cursor: not-allowed;" onclick="return false;"><i class="fa-solid fa-user-xmark"></i></a>
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
        //
        $("#BtnNewUser").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Usuario';
            $("#DataModalPrincipal").load("./views/usuarios/form_insert.php");
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });
        //
        $(".BtnUpdateUser").click(function() {
            let idusuario = $(this).attr("idusuario");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Modificar Usuario';
            $("#DataModalPrincipal").load("./views/usuarios/form_update.php?idusuario=" + idusuario);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {
            if ($('#usuario').val() === '' || $('#empleado').val() === '' || $('#clave').val() === '' || $('#tipo').val() === '' || $('#tipo').val() == null || $('#estado').val() === '' || $('#estado').val() == null) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let usuario, empleado, clave, estado, tipo;
            usuario = $('#usuario').val();
            empleado = $('#empleado').val();
            clave = $('#clave').val();
            estado = $('#estado').val();
            tipo = $('#tipo').val();

            var formData = {

                usuario: usuario,
                empleado: empleado,
                clave: clave,
                estado: estado,
                tipo: tipo
            };
            $.ajax({
                type: 'POST',
                url: './views/usuarios/insert.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#usuario').val('');
                    $('#empleado').val('');
                    $('#clave').val('');
                    $('#estado').val('');
                    $('#tipo').val('');
                    $("#DataPanelUsuarios").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#usuario').val() === '' || $('#empleado').val() === '' || $('#tipo').val() === '' || $('#tipo').val() == null || $('#estado').val() === '' || $('#estado').val() == null) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let idusuario, usuario, empleado, clave, estado, tipo;
            idusuario = $('#idusuario').val();
            usuario = $('#usuario').val();
            empleado = $('#empleado').val();
            clave = $('#clave').val();
            estado = $('#estado').val();
            tipo = $('#tipo').val();

            var formData = {
                idusuario: idusuario,
                usuario: usuario,
                empleado: empleado,
                clave: clave,
                estado: estado,
                tipo: tipo
            };
            $.ajax({
                type: 'POST',
                url: './views/usuarios/update.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#usuario').val('');
                    $('#empleado').val('');
                    $('#clave').val('');
                    $('#estado').val('');
                    $('#tipo').val('');
                    $("#DataPanelUsuarios").html(response);
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
                let idusuario = $(this).attr('idusuario');

                Swal.fire({
                    title: '¿Desea eliminar el usuario?',
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
                            url: './views/usuarios/del.php',
                            data: { idusuario: idusuario },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'El usuario ha sido eliminada.',
                                    'success'
                                );
                                $("#DataPanelUsuarios").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al eliminar el usuario',
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

    });
</script>