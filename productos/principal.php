<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$tipo = $_SESSION['tipo'];
$sql = "SELECT * FROM productos";

$result = $conn->query($sql);
$cont = 0;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="./public/css/botonatras.css">

<a href="./index.php" class="btn botonatras">
    <i class="fa-solid fa-reply"></i>Atrás
</a>
<div>
    <p style="text-align: center;"><b>Panel Productos</b></p>
</div>
<div class="table-responsive" id="DataPanelProductos">
    <a href="" class="btn text-white" style="background-color: #031A58;" id="BtnNewProd"><i class="fa-solid fa-circle-plus"></i></a>
    <a href="" class="btn text-white" style="float: right;background-color: #031A58;" id="Reload"><i class="fa-solid fa-rotate"></i></a>
    <hr>
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Stock <br>Alerta</th>
                    <th>Precio <br>Compra</th>
                    <th>Precio <br>Venta</th>
                    <th>Estado</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    $query = "SELECT COUNT(idproducto) as contIdProd FROM detalleventas WHERE idproducto='" . $data['idproducto'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdUser = $row2['contIdProd'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['producto']; ?></td>
                        <td>
                            <img src="./views/productos/imgproductos/<?php echo $data['img']; ?>" width="80px" alt="">
                        </td>
                        <td><?php echo $data['stock']; ?></td>
                        <td><?php echo $data['minimo']; ?></td>
                        <td>$<?php echo $data['pcompra']; ?></td>
                        <td>$<?php echo $data['pventa']; ?></td>
                        <td>
                            <?php
                            echo ($data['estado'] == 1) ? '<b style="color:green;">Disponible</b>' : '<b style="color:red;">No Disponible</b>';
                            ?>
                        </td>

                        <td>
                            <a href="" class="btn text-white BtnDetalleProd" idproducto="<?php echo $data['idproducto']; ?>" style="background-color: #078E10;"><i class="fa-solid fa-list-check"></i></a>
                        </td>
                        <td>
                            <?php if ($tipo == 1) : ?>
                                <a href="" class="btn text-white BtnUpdateProd" idproducto="<?php echo $data['idproducto']; ?>" style="background-color: #031A58;"><i class="fa-regular fa-pen-to-square"></i></a>
                            <?php else : ?>
                                <a href="" class="btn text-white " idproducto="<?php echo $data['idproducto']; ?>" style="background-color: #031A58;background-color: #ccc; cursor: not-allowed;" onclick="return false;"><i class="fa-regular fa-pen-to-square"></i></a>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if ($contIdUser == 0 && $tipo == 1) : ?>
                                <a href="" class="btn text-white BtnDeleteProd" idproducto="<?php echo $data['idproducto']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-trash-can"></i></a>
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
        $(".BtnDetalleProd").click(function() {
            let idproducto = $(this).attr("idproducto");
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModalProd").innerHTML = 'Detalles de Producto';
            $("#DataModalPrincipalProd").load("./views/productos/detalles.php?idproducto=" + idproducto);
            $('#ProcesoBotonModalProd').css('display', 'none');
            $('#ProcesoBotonModalProd2').css('display', 'none');
            document.getElementById("TituloBotonModalProd3").innerHTML = 'Cerrar';
            return false;
        });
        //
        $("#BtnNewProd").click(function() {
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModalProd").innerHTML = 'Registrar Producto';
            $("#DataModalPrincipalProd").load("./views/productos/form_insert.php");
            $('#ProcesoBotonModalProd').css('display', 'block');
            $('#ProcesoBotonModalProd2').css('display', 'none');
            document.getElementById("TituloBotonModalProd").innerHTML = 'Guardar';
            return false;
        });
        //
        $(".BtnUpdateProd").click(function() {
            let idproducto = $(this).attr("idproducto");
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModalProd").innerHTML = 'Modificar Producto';
            $("#DataModalPrincipalProd").load("./views/productos/form_update.php?idproducto=" + idproducto);
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
            if ($('#producto').val() === '' || $('#detalle').val() === '' || $('#stock').val() === '' || $('#pventa').val() === '' || $('#pcompra').val() === '' || $('#estado').val() === '' || $('#minimo').val() === '' || $('#img').val() === '' || $('#idproveedor').val() === '' || $('#idcategoria').val() === '') {
                alert('Por favor completa todos los campos.');
                return false;
            } else {
                if (accion == 1) {
                    $.ajax({
                            url: "./views/productos/insert.php",
                            type: "POST",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false
                        })
                        .done(function(result) {
                            $("#ModalPrincipalProd").modal("hide");
                            $("#DataPanelProductos").html(result);
                        });
                } else {
                    $.ajax({
                            url: "./views/productos/update.php",
                            type: "POST",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false
                        })
                        .done(function(result) {
                            $("#ModalPrincipalProd").modal("hide");
                            $("#DataPanelProductos").html(result);
                        });
                }
            }
            e.preventDefault();
        });
        //Proceso eliminar producto
        $('.BtnDeleteProd').click(function() {
                let idproducto = $(this).attr('idproducto');
                
                Swal.fire({
                    title: '¿Desea eliminar el producto?',
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
                            url: './views/productos/del.php',
                            data: {
                                idproducto: idproducto
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'El producto ha sido eliminado',
                                    'success'
                                );
                                $("#DataPanelProductos").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al eliminar el producto',
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
        /*// Proceso Delete
        $('.BtnDeleteProd').click(function() {
            var respuesta = confirm('¿Desea eliminar el producto...?');
            let idproducto = $(this).attr('idproducto');

            if (respuesta) {
                $.ajax({
                    type: 'POST',
                    url: './views/productos/del.php',
                    data: {
                        idproducto: idproducto
                    },
                    success: function(response) {
                        $("#DataPanelProductos").html(response);
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
            } else {
                alert('Proceso cancelado');
            }
            return false;
        });
        //
        $("#Reload").click(function() {
            $("#sub-data").load("./views/productos/principal.php");
            return false;
        });*/
    });
</script>