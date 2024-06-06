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
<!--FUNCION PARA CONVERTIR NUMEROS A LETRAS-->
<?php
function numeroALetras($numero)
{
    $num = (float)$numero;
    $decimales = explode('.', $num);
    $entero = $decimales[0];
    $centavos = isset($decimales[1]) ? $decimales[1] : '00';

    $unidades = array(
        '', 'uno', 'dos', 'tres', 'cuatro',
        'cinco', 'seis', 'siete', 'ocho', 'nueve'
    );
    $decenas = array(
        '', 'diez', 'veinte', 'treinta', 'cuarenta',
        'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'
    );
    $centenas = array(
        '', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos',
        'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'
    );

    $letras = '';

    if ($entero == 0) {
        $letras = 'cero';
    } elseif ($entero >= 1 && $entero <= 9) {
        $letras = $unidades[$entero];
    } elseif ($entero >= 10 && $entero <= 99) {
        if ($entero <= 15) {
            $letras = $unidades[$entero];
        } elseif ($entero <= 19) {
            $letras = 'dieci' . $unidades[$entero - 10];
        } else {
            $letras = $decenas[substr($entero, 0, 1)];
            $letras .= $unidades[substr($entero, 1, 1)];
        }
    } elseif ($entero >= 100 && $entero <= 999) {
        if ($entero == 100) {
            $letras = 'cien';
        } else {
            $letras = $centenas[substr($entero, 0, 1)];
            if (substr($entero, 1, 2) != 0) {
                $letras .= ' ' . numeroALetras((int)substr($entero, 1, 2));
            }
        }
    } elseif ($entero >= 1000 && $entero <= 999999) {
        $letras = numeroALetras((int)substr($entero, 0, -3)) . ' mil';
        if (substr($entero, -3) != 0) {
            $letras .= ' ' . numeroALetras((int)substr($entero, -3));
        }
    } elseif ($entero >= 1000000 && $entero <= 999999999) {
        $letras = numeroALetras((int)substr($entero, 0, -6)) . ' millones';
        if (substr($entero, -6) != 0) {
            $letras .= ' ' . numeroALetras((int)substr($entero, -6));
        }
    }

    $letras .= ' con ' . $centavos . '/100';
    return $letras;
}
?>



<?php
$codigo = generateRandomCode(); // Llama a la función que genera el código aleatorio

function generateRandomCode() {
    $length = 36; // Longitud del código
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Caracteres permitidos
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    // Añadir guiones en posiciones específicas
    $randomString = substr_replace($randomString, '-', 8, 0);
    $randomString = substr_replace($randomString, '-', 13, 0);
    $randomString = substr_replace($randomString, '-', 18, 0);
    $randomString = substr_replace($randomString, '-', 23, 0);
    return $randomString;
}

// Imprimir el código generado
//echo $codigo;

//para obtener codigo de generación
$codigogen = generateRandomCode2(); // Llama a la función que genera el código aleatorio

function generateRandomCode2() {
    // Genera el código aleatorio
    $randomString = 'DTE-01-S032P002-';
    $randomString .= str_pad(mt_rand(0, 999999999999), 15, '0', STR_PAD_LEFT); // Genera un número aleatorio con ceros a la izquierda
    return $randomString;
}

// Imprimir el código generado
//echo $codigogen;


//Generar sello
$sello = generateRandomCode3(); // Llama a la función que genera el código aleatorio

function generateRandomCode3() {
    // Genera el código aleatorio
    $randomString = strtoupper(substr(md5(uniqid(rand(), true)), 0, 22)); // Genera una cadena aleatoria de 22 caracteres
    return $randomString;
}

// Imprimir el código generado
//echo $sello;
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Electrónica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            border: 2px solid #000;
            padding: 20px;
        }
        h1, h2, h3 {
            text-align: center;
        }
        .header, .section {
            margin-bottom: 20px;
        }
        .header div, .section div {
            margin-bottom: 10px;
        }
        .box {
            width: 48%;
            padding: 10px;
            border: 1px solid #000;
            display: inline-block;
            vertical-align: top;
        }
        .small-box {
            width: 40%; /* Ajusta este valor según tus necesidades */
            font-size: 0.9em; /* Reduce el tamaño del texto */
            padding: 5px; /* Reduce el padding */
            margin-bottom: 10px; /* Reduce el margen inferior */
        }
        .small-box h3 {
            font-size: 1.1em; /* Reduce el tamaño del título */
            margin-bottom: 5px; /* Reduce el margen inferior del título */
        }
        .small-box div {
            margin-bottom: 5px; /* Reduce el margen inferior de los divs dentro de small-box */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2; /* Color de fondo para el encabezado */
            color: #000; /* Color del texto en el encabezado */
        }
        .right-align {
            text-align: right;
        }
        .total-section { text-align: right};
        
    </style>

</head>
<body>
    <div id="muestra">
        <div class="content" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div style="text-align: left;">
                <img class="img-fluid rounded" src="./public/img/logo.png" width="100px" alt="Logo">
                
            </div>
            <div>
                <h3>DOCUMENTO TRIBUTARIO ELECTRÓNICO</h3>
                <p style="text-align: center; font-weight: bold; color: #333333; font-size: 15px;">SOLUMAQ S.A de C.V</p>
                <p style="text-align: center; font-weight: bold; color: #333333; font-size: 15px;">FACTURA ELECTRÓNICA</p>
                <div><strong>Código de generación:</strong> <?php echo $codigo; ?></div>
                <div><strong>Número de control:</strong> <?php echo $codigogen; ?></div>
                <div><strong>Sello de recepción:</strong> <?php echo $sello; ?></div>
                <hr>
            </div>            
        </div>
        
        <br>
        <div class="section ">
                <div class="box small-box" style="float: left; max-width: 48%;">
                    <h4>EMISOR</h4>
                    <div><strong>Nombre:</strong> SOLUMAQ S.A de C.V</div>
                    <div><strong>NIT:</strong> 0614-290617-102-8</div>
                    <div><strong>NRC:</strong> 22347679</div>
                    <div><strong>Actividad económica:</strong> Almacenes (venta de diversos artículos)</div>
                    <div><strong>Dirección:</strong> Intersección NorOriente Carretera a Los Planes de Renderos Km. No.3. y Autopista a Comalapa. Bo. San Jacinto. San Salvador. El Salvador</div>
                    <div><strong>Teléfono:</strong> 2235-1024</div>
                    <div><strong>Correo:</strong> solumaq@correo.com</div>
                    <div><strong>Tipo de establecimiento:</strong> Sucursal / Agencia</div>
                </div>
                <div class="box small-box" style="float: left; max-width: 48%;">
                    <h4>RECEPTOR</h4>
                    <div><strong>Nombre:</strong> <?php echo $nombrecliente; ?></div>
                    <div><strong>Tipo de documento:</strong> DUI</div>
                    <div><strong>No. documento identificación:</strong> <?php echo $dui; ?></div>
                    <div><strong>Correo:</strong> <?php echo $email; ?></div>
                    <div><strong>Teléfono:</strong> <?php echo $telefono; ?></div>
                    <div><strong>Dirección:</strong> <?php echo $direccion; ?></div>
                </div>
            
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>N° Item</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Unidad de medida</th>
                        <th>Precio Unitario</th>
                        <th>Descuento</th>
                        <th>Ventas no sujetas</th>
                        <th>Ventas Exentas</th>
                        <th>Ventas Gravadas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detallesVentas as $data) : ?>
                        <?php
                        $idmaquina = $data['idmaquina'];
                        $dataProducto = "SELECT * FROM maquinas WHERE idmaquina='$idmaquina'";
                        $resultProd = $conn->query($dataProducto);
                        $rowProd = $resultProd->fetch_assoc();
                        $nproducto = "Alquiler de " . $rowProd['nombremaquina']." de ". $fecha_inicio." a ". $fecha_fin;
                        $pventa = $rowProd['precioalquiler'];
                        ?>
                        <tr>
                            <td><?php echo ++$contProdDV; ?></td>
                            <td><?php echo $nproducto; ?></td>
                            <td><?php echo $data['cantidad']; ?></td>
                            <td>Unidad</td>
                            <td>$<?php echo number_format($pventa, 2); ?></td>
                            <td>$0.00</td>
                            <td>$0.00</td>
                            <td>$0.00</td>
                            <td>$<?php echo number_format($data['total'], 2); ?></td> <!-- Aquí está la corrección -->
                        </tr>
                        <?php $contTotalProductos += $data['total']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <div class="total-section">
                <div><strong>Suma de ventas:</strong> $<?php echo number_format($contTotalProductos, 2); ?></div>
                <div><strong>Sub-Total:</strong> $<?php echo number_format($contTotalProductos, 2); ?></div>
                <div><strong>IVA retenido:</strong> $0.00</div>
                <div><strong>Retención renta:</strong> $0.00</div>
                <div><strong>Monto total de la operación:</strong> $<?php echo number_format($contTotalProductos, 2); ?></div>
                <div><strong>Total otros montos no afectos:</strong> $0.00</div>
                <div><strong>Total a pagar:</strong> $<?php echo number_format($contTotalProductos, 2); ?></div>            
            </div>
            <br>
            
            

        </div>
        
        
    </div>
    <script>
    function imprim2() {
        var carrera = "Factura electronica Alquiler";
        var mywindow = window.open('', 'PRINT', 'height=600,width=800');
        mywindow.document.write('<html><head><title>' + carrera + '</title>');
        mywindow.document.write('<style>' +
            'body { font-family: Arial, sans-serif; margin: 20px; }' +
            '.container { width: 80%; margin: auto; border: 2px solid #000; padding: 20px; }' +
            'h1, h2, h3 { text-align: center; }' +
            '.header, .section { margin-bottom: 20px; display: flex; justify-content: space-between; }' +
            '.header div, .section div { margin-bottom: 10px; }' +
            '.box { width: 48%; padding: 10px; border: 1px solid #000; display: inline-block; vertical-align: top; }' +
            '.small-box { width: 40%; font-size: 0.9em; padding: 5px; margin-bottom: 10px; }' +
            '.small-box h3 { font-size: 1.1em; margin-bottom: 5px; }' +
            '.small-box div { margin-bottom: 5px; }' +
            'table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }' +
            'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }' +
            'th { background-color: #F0DCBD; color: #000; }' + // Encabezado de la tabla con color de fondo
            '.right-align { text-align: right; }' +
            '.total-section { text-align: right; }' + // Estilo para la sección de suma de ventas a total a pagar
            
            '</style>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(document.getElementById('muestra').innerHTML);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.focus();
        mywindow.print();
        mywindow.close();

        return true;
    }
</script>





</body>
</html>


