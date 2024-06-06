<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$idpedido = $_GET['idpedido'];

// Consulta para obtener la información del pedido y su proveedor
$sqlPedido = "SELECT p.numero_orden, p.fecha, pr.proveedor, pr.telefono, pr.email, pr.direccion
              FROM pedidos p
              INNER JOIN productos prod ON p.idproducto = prod.idproducto
              INNER JOIN proveedores pr ON prod.idproveedor = pr.idproveedor
              WHERE p.idpedido = $idpedido";
$resultPedido = $conn->query($sqlPedido);
$rowPedido = $resultPedido->fetch_assoc();

// Consulta para obtener los detalles del pedido
$sqlDetallesPedido = "SELECT p.idproducto, p.nombre_producto, p.cantidad, prod.pcompra
                      FROM pedidos p
                      INNER JOIN productos prod ON p.idproducto = prod.idproducto
                      WHERE p.idpedido = $idpedido";
$resultDetallesPedido = $conn->query($sqlDetallesPedido);

//Informacion del cliente:
$Cliente = "SOLUMAQ S.A DE C.V";
$Direccion= "San Salvador";
$Telefono = "2243-0012";
$Email= "solumaq@correo.com";

$contTotalProductos = 0;

?>
<style>
    /* Estilos para el último div */
    #final {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #f9f9f9;
        padding: 20px;
        text-align: center;
    }
</style>

<div id="muestra">
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <div>
            <p style="text-align: center; font-weight: bold; color: #333333; font-size: 18px;">ORDEN DE COMPRA</p>
        </div>
        <div style="text-align: right;">
            <p><b>Orden de compra:</b> <?php echo $rowPedido['numero_orden']; ?></p>
            <p><b>Fecha:</b> <?php echo $rowPedido['fecha']; ?></p>
        </div>
    </div>
    <hr>
    <div style="margin-bottom: 20px;">
        <p style="text-align: center;"><b>Datos del proveedor</b></p>
        <ul style="list-style-type: none; padding: 0;">
            <li><b>Nombre:</b> <?php echo $rowPedido['proveedor']; ?></li>
            <li><b>Dirección:</b> <?php echo $rowPedido['direccion']; ?></li>
            <li><b>Teléfono:</b> <?php echo $rowPedido['telefono']; ?></li>
            <li><b>Email:</b> <?php echo $rowPedido['email']; ?></li>
        </ul>
    </div>
    <hr>
    <div style="margin-bottom: 20px;">
        <p style="text-align: center;"><b>Datos del cliente</b></p>
        <ul style="list-style-type: none; padding: 0;">
            <li><b>Nombre:</b> <?php echo $Cliente; ?></li>
            <li><b>Dirección:</b> <?php echo $Direccion; ?></li>
            <li><b>Teléfono:</b> <?php echo $Telefono; ?></li>
            <li><b>Email:</b> <?php echo $Email; ?></li>
        </ul>
    </div>
    <hr>
    <div style="margin-bottom: 20px;">
        <p style="text-align: center;"><b>Detalle del pedido</b></p>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 90%; border-collapse: collapse; border: 2px solid black; border-collapse: collapse;" border="1">
            <thead style="vertical-align: middle; text-align: center; border: 2px solid black; border-collapse: collapse;">
                <tr style="background-color: #1F6D70; color: white; ">
                    <th>Ref</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Precio total</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php while ($rowDetallesPedido = $resultDetallesPedido->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $rowDetallesPedido['idproducto']; ?></td>
                        <td><?php echo $rowDetallesPedido['nombre_producto']; ?></td>
                        <td><?php echo $rowDetallesPedido['cantidad']; ?></td>
                        <td>$<?php echo number_format($rowDetallesPedido['pcompra'], 2); ?></td>
                        <td>$<?php $subtotal = $rowDetallesPedido['cantidad'] * $rowDetallesPedido['pcompra']; echo number_format($subtotal, 2); $contTotalProductos += $subtotal; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <br><br>
    <div style="margin-bottom: 20px;">
        <p style="text-align: center;"><b>Detalle final</b></p>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 90%; border-collapse: collapse; border: 2px solid black; border-collapse: collapse;" border="1">
            <tr>
                <td style="background-color: #1F6D70; color: white;"b>Total Pedido:</b></td>
                <td style="border: 1px solid black; padding: 5px;">$<?php echo number_format($contTotalProductos, 2); ?></td>
            </tr>
            <tr>
                <td style="background-color: #1F6D70; color: white; "><b>Gastos de envío:</b></td>
                <td style="border: 1px solid black; padding: 5px;">$200.00</td>
            </tr>
            <tr>
                <td style="background-color: #1F6D70; color: white; "><b>Total a pagar:</b></td>
                <td style="border: 1px solid black; padding: 5px;">$<?php echo number_format($contTotalProductos + 200, 2); ?></td>
            </tr>
        </table>
    </div>
    <br><br><br><br>
    
    <div style="margin-bottom: 100px; float: right;" >
        <p ><b>Fecha de entrega:</b> <?php echo date('Y-m-d', strtotime($rowPedido['fecha'] . ' + 15 days')); ?></p>
        <p ><b>Direccion de entrega:</b> Intersección NorOriente Carretera a Los Planes de Renderos Km. No.3. y Autopista a Comalapa. Bo. San Jacinto. San Salvador. El Salvador</p>
        <br><br><br><br><br><br>
        <p ><b>______________________</b></p>
        <p ><b>Firma del receptor</b></p>
    </div>
</div>
<script>
    function imprim2() {
        var numeroCompra = "<?php echo $rowPedido['numero_orden']; ?>"; // Obtener el número de compra
        var carrera = "Comprobante de Venta - Número de Compra: " + numeroCompra;
        var mywindow = window.open('', 'PRINT', 'height=600,width=800');
        mywindow.document.write('<html><head><title>' + carrera + '</title>');
        mywindow.document.write(
            '<style>body{margin: 20mm 10mm 20mm 10mm; font-size:11px;font-family: "Roboto Condensed", sans-serif !important;} table {border-collapse: collapse;font-size:10px;}</style>'
        );
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById('muestra').innerHTML);
        mywindow.document.write('</body></html>');
        mywindow.document.close(); // necesario para IE >= 10
        mywindow.focus(); // necesario para IE >= 10
        mywindow.print();
        mywindow.close();

        return true;
    }
</script>

