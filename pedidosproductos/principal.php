<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$tipo = $_SESSION['tipo'];
$sql = "SELECT 
p.*,
pv.proveedor
FROM 
pedidos p
INNER JOIN 
productos pr ON p.idproducto = pr.idproducto
INNER JOIN 
proveedores pv ON pr.idproveedor = pv.idproveedor
";
$result = $conn->query($sql);

$cont = 0;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="./public/css/botonatras.css">
<a href="./index.php" class="btn botonatras">
    <i class="fa-solid fa-reply"></i>Atrás
</a>
<div>
    <p style="text-align: center;"><b>Detalle de pedido de productos</b></p>
</div>
<div class="table-responsive" id="DataPanelAlquiler">
    <hr>
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Numero de orden</th>
                    <th>Proveedor</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Documento</th>                    
                    
                    <!-- Agrega más columnas según los campos de la tabla detallealquiler -->
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['numero_orden']; ?></td>
                        <td><?php echo $data['proveedor']; ?></td>
                        <td><?php echo $data['nombre_producto']; ?></td>
                        <td><?php echo $data['cantidad']; ?></td>
                        <td class="ocultar-en-impresion">
                            <a href="" class="btn text-white BtnImprimirPedido" idpedido="<?php echo $data['idpedido']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-file-pdf"></i></a>
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
        $(".BtnImprimirPedido").click(function() {
            let idpedido = $(this).attr('idpedido');
            $("#ModalPrincipal2").modal("show");
            $('#DataEfectosModal2').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModal2").innerHTML = 'Comprobante de Alquiler';
            $("#DataModalPrincipal2").load("./views/pedidosproductos/comprobante.php?idpedido=" + idpedido);
            return false;
        });

    });
</script>
<!--
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

</script> -->








