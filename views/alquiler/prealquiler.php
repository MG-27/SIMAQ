<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$idusuario = $_SESSION['idusuario'];
$ventasEstado0 = "SELECT * FROM alquiler WHERE estado=0 AND idusuario='$idusuario'";
$result = $conn->query($ventasEstado0);
$row = $result->fetch_assoc();
$idalquiler = $row['idalquiler'];
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

$clienteInfo = "SELECT * FROM clientes WHERE nombrecliente='$nombrecliente' AND estado =1";
$resultCliente = $conn->query($clienteInfo);
$cliente = $resultCliente->fetch_assoc();
$telefono = $cliente['telefono'];
$direccion = $cliente['direccion'];
$dui = $cliente['dui'];
$email = $cliente['email'];
?>
<div>
    <p style="text-align: center;"><b>Agregar Máquinas al alquiler</b></p>
    <hr>
    <i class="fa-solid fa-clipboard-check"></i> : <b>Cerrar Alquiler</b> | <i class="fa-solid fa-eraser"></i> : <b>Eliminar Alquiler</b>
    <hr>
    <hr>
    <!--Cuadro que me permite agregar los productos que desee al alquiler-->
    <p style="text-align: center;"><b>INFORMACIÓN DEL CLIENTE</b></p>
    <hr>
    <ul style="list-style-type: none; padding: 0;">
        <li><b>nombre cliente: </b><?php echo $nombrecliente; ?></li>
        <li><b>DUI: </b> <?php echo $dui; ?></li>
        <li><b>Contacto: </b><?php echo $nombrecliente; ?></li>
        <li><b>Correo electronico: </b> <?php echo $email; ?></li>
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
    <!--Cuadro que me permite agregar los productos que desee al alquiler-->
    <p style="text-align: center;"><b>INFORMACIÓN DE MAQUINARIA</b></p>
    <hr>
    <?php if ($detallesVentas && $detallesVentas->num_rows > 0) : ?>
        <hr>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Máquina</th>
                    <th>Precio <br>Alquiler</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th><i class="fa-solid fa-trash-can"></i></th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($detallesVentas as $data) : ?>
                    <?php
                    $idprod = $data['idmaquina'];
                    $dataProducto = "SELECT * FROM maquinas WHERE idmaquina='$idprod'";
                    $resultProd = $conn->query($dataProducto);
                    $rowProd = $resultProd->fetch_assoc();
                    $nproducto = $rowProd['nombremaquina'];
                    $precioalquiler = $rowProd['precioalquiler'];
                    ?>
                    <tr>
                        <td><?php echo ++$contProdDV; ?></td>
                        <td><?php echo $nproducto; ?></td>
                        <td>$<?php echo number_format($precioalquiler,2); ?></td>
                        <td>
                            <?php
                            echo $data['cantidad'];
                            $contTproductos += $data['cantidad'];
                            ?>
                        </td>
                        <td>
                            $<?php
                                echo number_format($data['total'],2);
                                $contTotalProductos += $data['total'];
                            ?>
                        </td>
                        <td>
                            <a href="" class="btn text-white BtnDelProductoCarrito" iddetallealquiler="<?php echo $data['iddetallealquiler']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="3">Total</td>
                    <td><?php echo $contTproductos; ?></td>
                    <td>$<?php echo number_format($contTotalProductos,2);?></td>
                </tr>
            </tbody>
        </table>
        <a href="" class="btn BtnCerrarVenta" style="background-color: #031A58;color:white;margin-top: 10px;" idalquiler="<?php echo $data['idalquiler']; ?>"><b><i class="fa-solid fa-clipboard-check"></i></b></a>
    <?php else : ?>
        <br>
        <a href="" class="btn BtnEliminarVenta" style="background-color: #031A58;color:white;margin-top: 10px;" idalquiler="<?php echo $idalquiler; ?>"><b><i class="fa-solid fa-eraser"></i></b></a>
        <div class="alert alert-danger">
            <b>No se encuentran productos agregados al carrito</b>
        </div>
    <?php endif ?>
</div>
<hr>
<!--Cuadro que me permite agregar los productos que desee al alquiler-->
<p style="text-align: center;"><b>Maquinaria</b></p>
<hr>
<div>
    <?php if ($dataProductos && $dataProductos->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Máquina</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Precio <br>Alquiler</th>
                    <th>Cantidad</th>
                    <th><i class="fa-solid fa-cart-plus"></i></th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($dataProductos as $data) : ?>
                    <tr>
                        <td><?php echo ++$contProd; ?></td>
                        <td><?php echo $data['nombremaquina']; ?></td>
                        <td>
                            <img src="./views/maquinas/imgmaquinas/<?php echo $data['img']; ?>" width="80px" alt="">
                        </td>
                        <td><?php echo $data['cantidadstock']; ?></td>
                        <td>
                            $<?php echo $data['precioalquiler']; ?>
                        </td>
                        <td>
                            <input type="number" class="form-control" style="width: 80px;" name="cantidad" id="cantidad-<?php echo $data['idmaquina']; ?>" value="0" min="0">
                        </td>
                        <td>
                            <a href="" class="btn text-white BtnAddProducto" idmaquina="<?php echo $data['idmaquina']; ?>" idalquiler="<?php echo $idalquiler; ?>" precioalquiler="<?php echo $data['precioalquiler']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-cart-plus"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-danger">
            <b>No se encuentran productos</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>
<script>
    $(document).ready(function() {
        // Proceso ADD maquina ya funciona
        $('.BtnAddProducto').click(function() {
            let idmaquina = $(this).attr('idmaquina');
            let cantidad = $("#cantidad-" + idmaquina).val();
            let precioalquiler = $(this).attr('precioalquiler');
            let idalquiler = $(this).attr('idalquiler');

            Swal.fire({
                title: '¿Desea agregar máquina al carrito?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (cantidad == 0 || cantidad == null) {
                        Swal.fire('Error', 'Favor de seleccionar la cantidad de maquinas', 'error');
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: './views/alquiler/regdetallealquiler.php',
                            data: {
                                idmaquina: idmaquina,
                                cantidad: cantidad,
                                precioalquiler: precioalquiler,
                                idalquiler: idalquiler
                            },
                            success: function(response) {
                                $("#DataVentas").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', xhr.responseText, 'error');
                            }
                        });
                    }
                } else {
                    Swal.fire('Cancelado', 'Proceso cancelado', 'error');
                }
            });
            return false;
        });

        // Proceso DEL Maquina del carrito ya funciona
        $('.BtnDelProductoCarrito').click(function() {
            let iddetallealquiler = $(this).attr('iddetallealquiler');

            Swal.fire({
                title: '¿Desea eliminar máquina del carrito?',
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
                        url: './views/alquiler/delcarrito.php',
                        data: {
                            iddetallealquiler: iddetallealquiler
                        },
                        success: function(response) {
                            $("#DataVentas").html(response);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', xhr.responseText, 'error');
                        }
                    });
                } else {
                    Swal.fire('Cancelado', 'Proceso cancelado', 'error');
                }
            });
            return false;
        });

        // Proceso Cerrar Venta
        $('.BtnCerrarVenta').click(function() {
            let idalquiler = $(this).attr('idalquiler');

            Swal.fire({
                title: '¿Desea cerrar el proceso de alquiler?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: './views/alquiler/cerrar.php',
                        data: {
                            idalquiler: idalquiler
                        },
                        success: function(response) {
                            $("#DataVentas").html(response);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', xhr.responseText, 'error');
                        }
                    });
                } else {
                    Swal.fire('Cancelado', 'Proceso cancelado', 'error');
                }
            });
            return false;
        });

        // Proceso Eliminar Alquiler
        $('.BtnEliminarVenta').click(function() {
        let idalquiler = $(this).attr('idalquiler');

        Swal.fire({
            title: '¿Desea eliminar el registro de alquiler?',
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
                    url: './views/alquiler/delalquiler.php',
                    data: { idalquiler: idalquiler },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Eliminado', response.message, 'success').then(() => {
                                $("#sub-data").load("./views/alquiler/principal.php");
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Error al eliminar el registro de alquiler', 'error');
                    }
                });
            } else {
                Swal.fire('Cancelado', 'Proceso cancelado', 'error');
            }
        });
        return false;
    });
    });
</script>
