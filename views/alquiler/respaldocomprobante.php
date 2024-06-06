<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$idalquiler = $_GET['idalquiler'];
$ventasEstado0 = "SELECT * FROM alquiler WHERE idalquiler='$idalquiler'";
$result = $conn->query($ventasEstado0);
$row = $result->fetch_assoc();
$nombrecliente = $row['nombrecliente'];
$fecha_inicio = $row['fecha_inicio'];
$fecha_fin = $row['fecha_fin'];
$tipo_alquiler = $row['tipo_alquiler'];

$sql = "SELECT * FROM maquinas WHERE cantidadstock > 0 AND estado = 1";
$dataProductos = $conn->query($sql);

$sqlDV = "SELECT * FROM detallealquiler WHERE idalquiler='$idalquiler' AND estado = 1";
$detallesVentas = $conn->query($sqlDV);

$contProd = 0;
$contProdDV = 0;
$contTproductos = 0;
$contTotalProductos = 0;

//INFORMACION PARA MOSTRAR EL CLIENTE
$clienteInfo = "SELECT * FROM clientes WHERE nombrecliente='$nombrecliente' AND estado =1";
$resultCliente = $conn->query($clienteInfo);
$cliente = $resultCliente->fetch_assoc();
$telefono = $cliente['telefono'];
$direccion = $cliente['direccion'];
$dui = $cliente['dui'];
$email = $cliente['email'];
?>
<div id="muestra">
    <div style="text-align: center;">
        <img class="img-fluid rounded" src="./public/img/logo.png" width="100px" alt="Logo">
        <p style="text-align: center;"><b>SOLUMAQ S.A DE C.V</b></p>
    </div>
    <hr style="border: 3px solid #151171;">
        <!--Cuadro que me permite agregar los productos que desee al alquiler-->
        <p style="text-align: center; font-weight: bold; color: #333333; font-size: 18px;">DETALLE COMPROBANTE DE ALQUILER</p>
    <hr style="border: 3px solid #151171;">
    
    <hr>
    <!--Cuadro que me permite agregar los productos que desee al alquiler-->
    <p style="text-align: center;"><b>INFORMACIÓN DEL CLIENTE</b></p>
    <hr>
    <ul style="list-style-type: none; padding: 0;">
        <li><b>Nombre: </b><?php echo $nombrecliente; ?></li>
        <li><b>DUI: </b> <?php echo $dui; ?></li>
        <li><b>Contacto: </b><?php echo $nombrecliente; ?></li>
        <li><b>Correo electrónico: </b> <?php echo $email; ?></li>
        <li><b>Dirección: </b><?php echo $direccion; ?></li>
    </ul>
    <hr>
    <hr>
    <!--Cuadro que me permite agregar los productos que desee al alquiler-->
    <p style="text-align: center;"><b>INFORMACIÓN DEL ALQUILER</b></p>
    <hr>
    <ul style="list-style-type: none; padding: 0;">
        <li><b>Fecha de inicio: </b><?php echo $fecha_inicio; ?></li>
        <li><b>Fecha de finalización: </b> <?php echo $fecha_fin; ?></li>
        <li><b>Tipo de Alquiler: </b><?php echo $tipo_alquiler ?></li>        
    </ul>
    <hr>
    <hr>
    <!--Cuadro que me permite agregar los productos que desee al alquiler-->
    <p style="text-align: center;"><b>INFORMACIÓN DE MAQUINARIA</b></p>
    <hr>
    <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 90%; border-collapse: collapse; border: 2px solid black; border-collapse: collapse;" border="1">
        <thead style="vertical-align: middle; text-align: center; border: 2px solid black; border-collapse: collapse;">
            <tr style="background-color: #1F6D70; color: white; ">
                <th>N°</th>
                <th>Máquina</th>
                <th>Precio <br>Alquiler</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody style="vertical-align: middle; text-align: center;">
            <?php foreach ($detallesVentas as $data) : ?>
                <?php
                $idmaquina = $data['idmaquina'];
                $dataProducto = "SELECT * FROM maquinas WHERE idmaquina='$idmaquina'";
                $resultProd = $conn->query($dataProducto);
                $rowProd = $resultProd->fetch_assoc();
                $nproducto = $rowProd['nombremaquina'];
                $precioalquiler = $rowProd['precioalquiler'];
                ?>
                <tr>
                    <td><?php echo ++$contProdDV; ?></td>
                    <td><?php echo $nproducto; ?></td>
                    <td>$<?php echo number_format($precioalquiler, 2); ?></td>
                    <td>
                        <?php
                        echo $data['cantidad'];
                        $contTproductos += $data['cantidad'];
                        ?>
                    </td>
                    <td>
                        $<?php
                            echo number_format($data['total'], 2);
                            $contTotalProductos += $data['total'];
                            ?>
                    </td>
                </tr>
            <?php endforeach ?>
            <tr style="background-color: #B9DADC;">
                <td colspan="3">Total</td>
                <td><?php echo $contTproductos; ?></td>
                <td>$<?php echo number_format($contTotalProductos, 2); ?></td>
            </tr>
        </tbody>
    </table>
</div>


<script>
    function imprim2() {
        var carrera = "Comprobante de Alquiler";
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