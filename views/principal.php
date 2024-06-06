<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include './models/conexion.php';
include './controllers/controllersFunciones.php';
$conn = conectar_db();
$usuario = $_SESSION['usuario'];
$tipo = $_SESSION['tipo'];
/* El fragmento de código ` = "SELECT * FROM productos WHERE stock <= minimo AND estado =1";
 = ->query();` está realizando una consulta de base de datos en PHP. */
$sql = "SELECT * FROM productos WHERE stock <= minimo AND estado =1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página</title>
    <link rel="stylesheet" href="./public/css/botones.css">
    <link rel="stylesheet" href="./public/css/botones2.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <div class="card" style="margin-top:15px;">
        <div class="btn text-dark" style="background-color: #FFA61D;">
            <b>Bienvenid@: <?php echo $usuario; ?></b>
        </div>
        <div class="card-body" id="sub-data">
            <p style="text-align: center"><b>Sistema de Inventario SOLUMAQ (SIMAQ)</b></p>

            <?php
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="alert alert-warning">';
                    echo "<b>¡Alerta! Producto con stock bajo:</b><br>";
                    echo "Producto: " . $row["producto"] . " | Stock: " . $row["stock"] . " | Stock Minimo: " . $row["minimo"];
                    echo '<div style="text-align: right;">';
                    echo '<button class="btn btn-primary pedidoProducto" data-nombreproducto="' . $row["producto"] . '">Realizar Pedido</button>';
             

                    echo '</div>';
                    echo '</div>';
                }
            }
            $conn->close();
            ?>          

            <div style="text-align: center">
                <img class="img-fluid rounded" src="./public/img/logo.png" width="180px" alt="Logo">
            </div>
            <div class="row" style="vertical-align: middle;text-align: center;">
                <?php if ($tipo == 1) : ?>
                    <div class="col-md-4">                        
                      <a href="#" class="btn button3" id="Panel-Usuarios"><b><i class="fa-solid fa-users"></i> Usuarios</b></a>
                      <hr>
                      <a href="" class="btn button3" id="Panel-Productos"><b><i class="fa-solid fa-cube"></i>Productos</b></a>
                      <hr>
                      <a href="" class="btn button3" id="Panel-Pedidos"><b><i class="fa-solid fa-cube"></i>Pedidos</b></a>                      
                    </div>
                    <div class="col-md-4">
                        <a href="" class="btn button3" id="Panel-Categorias"><b><i class="fa-solid fa-layer-group"></i>Categorías</b></a>
                        <hr>
                        <a href="" class="btn button3" id="Panel-Ventas"><b><i class="fa-solid fa-cart-shopping"></i>Ventas</b></a>
                    </div>
                    <div class="col-md-4">
                        <a href="" class="btn button3" id="Panel-Proveedores"><b><i class="fa-solid fa-building"></i>Proveedor</b></a>                              
                        <hr>
                        <a href="" class="btn button3" id="Panel-Reportes"><b><i class="fa-solid fa-box-archive"></i>Reportes</b></a>                      
                        
                    </div>
                    <div class="col-md-12" style="margin-top:50px;">
                        <p style="text-align: center"><b>Alquiler de Maquinaria de Terracería</b></p>
                    </div>
                    <div class="col-md-4">
                        <a href="" class="btn nuevoboton" id="Panel-Clientes"><b><i class="fa-solid fa-users-line"></i> Clientes</b></a>                              
                        <hr> 
                        <a href="" class="btn nuevoboton" id="Panel-Maquinas"><b><i class="fa-solid fa-truck-pickup"></i> Máquinas</b></a>                              
                        <hr>                                             
                    </div>                    
                    <div class="col-md-4">
                        <a href="" class="btn nuevoboton" id="Panel-Alquiler"><b><i class="fa-solid fa-file-signature"></i> Alquiler</b></a>                              
                        <hr>
                        <a href="" class="btn nuevoboton"  id="Panel-ReportesAlquiler"><b><i class="fa-solid fa-box-archive"></i> Reportes</b></a>                              
                        <hr>                                                 
                    </div>
                    <div class="col-md-4">
                        <a href="" class="btn nuevoboton" id="Panel-EstadoAlquiler"><b><i class="fa-solid fa-clock-rotate-left"></i> Estados</b></a>                              
                        <hr>                                                                        
                    </div>
                    
                <?php else : ?>
                    <div class="col-md-6">
                        <a href="" class="btn button3" id="Panel-Categorias"><b><i class="fa-solid fa-layer-group"></i>Categorías</b></a>
                        <hr>
                        <a href="" class="btn button3" id="Panel-Proveedores"><b><i class="fa-solid fa-building"></i>Proveedor</b></a> 
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn button3" id="Panel-Productos"><b><i class="fa-solid fa-cube"></i>Productos</b></a>
                        <hr>
                        <a href="" class="btn button3" id="Panel-Ventas"><b><i class="fa-solid fa-cart-shopping"></i>Ventas</b></a>
                    </div>
                    <div class="col-md-12" style="margin-top:50px;">
                        <p style="text-align: center"><b>Alquiler de Maquinaria de Terracería</b></p>
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn nuevoboton" id="Panel-Clientes"><b><i class="fa-solid fa-truck-pickup"></i> Clientes</b></a>                              
                        <hr>                                              
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn nuevoboton" id="Panel-Maquinas"><b><i class="fa-solid fa-truck-pickup"></i> Máquinas</b></a>                              
                        <hr>                                              
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn nuevoboton" id="Panel-Alquiler"><b><i class="fa-solid fa-file-signature"></i> Alquiler</b></a>                              
                                                                     
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn nuevoboton" id="Panel-EstadoAlquiler"><b><i class="fa-solid fa-clock-rotate-left"></i> Estados</b></a>                              
                                                                                               
                    </div>
                    
                <?php endif ?>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#Panel-Usuarios").click(function() {
                $("#sub-data").load("./views/usuarios/principal.php");
                return false;
            });

            $("#Panel-Productos").click(function() {
                $("#sub-data").load("./views/productos/principal.php");
                return false;
            });

            $("#Panel-Categorias").click(function() {
                $("#sub-data").load("./views/categorias/principal.php");
                return false;
            });

            $("#Panel-Proveedores").click(function() {
                $("#sub-data").load("./views/proveedores/principal.php");
                return false;
            });

            $("#Panel-Reportes").click(function() {
                $("#sub-data").load("./views/reportes/principal.php");
                return false;
            });

            $("#Panel-Ventas").click(function() {
                $("#sub-data").load("./views/ventas/principal.php");
                return false;
            });
            $("#Panel-Maquinas").click(function() {
                $("#sub-data").load("./views/maquinas/principal.php");
                return false;
            });
            $("#Panel-Alquiler").click(function() {
                $("#sub-data").load("./views/alquiler/principal.php");
                return false;
            });
            $("#Panel-Clientes").click(function() {
                $("#sub-data").load("./views/clientes/principal.php");
                return false;
            });
            $("#Panel-ReportesAlquiler").click(function() {
                $("#sub-data").load("./views/reportesalquiler/principal.php");
                return false;
            });
            $("#Panel-EstadoAlquiler").click(function() {
                $("#sub-data").load("./views/estadosalquiler/principal.php");
                return false;
            });
            $("#Panel-Pedidos").click(function() {
                $("#sub-data").load("./views/pedidosproductos/principal.php");
                return false;
            });
        });



    </script>
<!-- Script para controlar los pedidos-->
<script>
    $(document).ready(function() {
        // Botón para abrir el modal de realizar pedido
        $(".pedidoProducto").click(function() {
            var nombreProducto = $(this).data("nombreproducto"); 
            console.log(nombreProducto);
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Realizar Pedido';
            // Utilizar el nombre del producto en la URL del load
            $("#DataModalPrincipalProd").load("./views/pedidosproductos/form_pedidos.php?nombreproducto=" + nombreProducto);
            document.getElementById("DataTituloModalProd").innerHTML = 'Realizar pedido';
            $('#ProcesoBotonModalProd').css('display', 'none');
            $('#ProcesoBotonModalProd2').css('display', 'block');
            document.getElementById("TituloBotonModalProd2").innerHTML = 'Enviar';
            return false;
        });
        // Proceso de envío del formulario
        $("#AccionProductos").on('submit', function(e) {
            e.preventDefault();
            let accion = $('#accion').val();
            
            var formData = new FormData(document.getElementById("AccionProductos"));

            // Validar que el campo de cantidad esté completo
            if ($('#stock').val() === '') {
                alert('Por favor completa el campo de cantidad.');
                return false;
            } else {
                $.ajax({
                    url: "./views/pedidosproductos/guardar_pedido.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                })
                .done(function(result) {
                    console.log("peticion ajax");
                    $("#ModalPrincipalProd").modal("hide");
                    $("#DataPanelProductos").html(result);
                });
            }
        });
    });
</script>




<!--<script>
    $(document).ready(function() {
        $(".BtnUpdateProd").click(function() {
            let idproducto = $(this).attr("idproducto");
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            // Limpiar el contenido del modal antes de cargar nuevo contenido
            $("#DataModalPrincipalProd").empty();
            // Cargar el contenido del modal
            $("#DataModalPrincipalProd").load("./views/productos/form_update.php?idproducto=" + idproducto);
            document.getElementById("DataTituloModalProd").innerHTML = 'Modificar Producto';
            $('#ProcesoBotonModalProd').css('display', 'none');
            $('#ProcesoBotonModalProd2').css('display', 'block');
            document.getElementById("TituloBotonModalProd2").innerHTML = 'Actualizar';
            return false;
        });

        $("#ProcesoBotonModalProd2").click(function() {
            $("#formPedido").submit();
        });
    });
</script>-->




</body>

</html>
