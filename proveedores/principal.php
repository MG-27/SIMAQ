<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$sql = "SELECT * FROM proveedores";

$result = $conn->query($sql);
$cont = 0;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="./public/css/botonatras.css">

<a href="./index.php" class="btn botonatras">
    <i class="fa-solid fa-reply"></i>Atrás
</a>
<div>
    <p style="text-align: center;"><b>Panel Proveedores</b></p>
</div>
<div class="table-responsive" id="DataPanelProveedores">
    <a href="" class="btn text-white" style="background-color: #031A58;" id="BtnNewProv"><i class="fa-solid fa-circle-plus"></i></a>
    <a href="" class="btn text-white" style="float: right;background-color: #031A58;" id="Reload"><i class="fa-solid fa-rotate"></i></a>
    <hr>
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Proveedor</th>
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
                    $query = "SELECT COUNT(idproveedor) as contId FROM productos WHERE idproveedor='" . $data['idproveedor'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdProv = $row2['contId'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['proveedor']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo $data['direccion']; ?></td>
                        <td><?php echo ($data['estado'] == 1) ? '<b style="color:green;">Activo</b>' : '<b style="color:red;">Inactivo</b>'; ?></td>
                        <td>
                            <a href="" class="btn text-white BtnUpdateUser" idproveedor="<?php echo $data['idproveedor']; ?>" style="background-color: #078E10;"><i class="fa-regular fa-pen-to-square"></i></a>
                        </td>
                        <td>
                            <?php if ($contIdProv == 0) : ?>
                                <a href="" class="btn text-white BtnDeleteUser" idproveedor="<?php echo $data['idproveedor']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-trash-can"></i></a>
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
            <b>No se encuentran datos</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>

<script>
    $(document).ready(function() {
        //
        $("#BtnNewProv").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Proveedor';
            $("#DataModalPrincipal").load("./views/proveedores/form_insert.php");
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });
        //
        $(".BtnUpdateUser").click(function() {
            let idproveedor = $(this).attr("idproveedor");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Modificar Usuario';
            $("#DataModalPrincipal").load("./views/proveedores/form_update.php?idproveedor=" + idproveedor);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {
            if ($('#proveedor').val() === '' || $('#telefono').val() === '' || $('#email').val() === '' || $('#direccion').val() == null || $('#estado').val() === '' || $('#estado').val() == null) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let proveedor, telefono, email, estado, direccion;
            proveedor = $('#proveedor').val();
            telefono = $('#telefono').val();
            email = $('#email').val();
            estado = $('#estado').val();
            direccion = $('#direccion').val();

            var formData = {

                proveedor: proveedor,
                telefono: telefono,
                email: email,
                estado: estado,
                direccion: direccion
            };
            $.ajax({
                type: 'POST',
                url: './views/proveedores/insert.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#proveedor').val('');
                    $('#telefono').val('');
                    $('#email').val('');
                    $('#estado').val('');
                    $('#direccion').val('');
                    $("#DataPanelProveedores").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#proveedor').val() === '' || $('#telefono').val() === '' || $('#email').val() === '' || $('#direccion').val() == null || $('#estado').val() === '' || $('#estado').val() == null) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let idproveedor, proveedor, telefono, email, estado, direccion;
            idproveedor = $('#idproveedor').val();
            proveedor = $('#proveedor').val();
            telefono = $('#telefono').val();
            email = $('#email').val();
            estado = $('#estado').val();
            direccion = $('#direccion').val();

            var formData = {
                idproveedor: idproveedor,
                proveedor: proveedor,
                telefono: telefono,
                email: email,
                estado: estado,
                direccion: direccion
            };
            $.ajax({
                type: 'POST',
                url: './views/proveedores/update.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#usuario').val('');
                    $('#telefono').val('');
                    $('#email').val('');
                    $('#estado').val('');
                    $('#direccion').val('');
                    $("#DataPanelProveedores").html(response);
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
                let idproveedor = $(this).attr('idproveedor');

                Swal.fire({
                    title: '¿Desea eliminar el proveedor?',
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
                            url: './views/proveedores/del.php',
                            data: { idproveedor: idproveedor },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'El proveedor ha sido eliminado',
                                    'success'
                                );
                                $("#DataPanelProveedores").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al eliminar el proveedor.',
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
            $("#sub-data").load("./views/proveedores/principal.php");
            return false;
        });
    });
</script>