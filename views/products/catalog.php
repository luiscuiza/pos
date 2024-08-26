<?php 
    global $env;
    $tableID = 'products';
    $tableColsConfig = <<<EOD
        { "width": "110px", "targets": 0 },    
        { "width": "135px", "targets": 1 },
    EOD;
?>
<!-- HEAD CSS -->
<?php ob_start(); ?>
    <?php include 'views/layout/ListCss.php'; ?>
<?php $headCss = ob_get_clean(); ?>

<!-- BODY JS -->
<?php ob_start(); ?>
    <?php include 'views/layout/ListJs.php'; ?>
    <?php include 'views/layout/TableConfig.php'; ?>
    <script>
        function sincronizeCatalog() {
            var data = {
                codigoAmbiente: 2,
                codigoPuntoVenta: 0,
                codigoPuntoVentaSpecified: true,
                codigoSucursal: 0,
                codigoSistema: "<?php echo $env->get('codsys') ?>",
                cuis: "<?php echo $env->get('cuis')  ?>",
                nit: <?php echo $env->get('nit') ?>
            };
            $.ajax({
                url: 'http://localhost:5000/Sincronizacion/listaproductosservicios?token=<?php echo $env->get('token') ?>',
                method: 'POST',
                data: JSON.stringify(data),
                cache: false,
                contentType: "application/json",
                success: function(data) {
                    var table = $("#<?php echo $tableID ?>").DataTable();
                    data.listaCodigos.forEach((item)=>{
                        table.row.add([
                            item.codigoActividad,
                            item.codigoProducto,
                            item.descripcionProducto
                        ]);
                    });
                    table.draw();
                }
            });
        }
    </script>
<?php $bodyJs = ob_get_clean(); ?>

<section class="content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Sincronización de productos</h1>
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="sincronizeCatalog()">
                                <i class="fas fa-sync"></i> Sincronizar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="<?php echo $tableID ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Cod. Actividad</th>    
                                    <th>Cod. Producto SIN</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
