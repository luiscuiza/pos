<?php 
    global $env;
    $tableID = 'products';
    $tableColsConfig = <<<EOD
        { "width": "100px", "targets": 0 },
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
        function sincronizeUnit() {
            $.ajax({
                url: '/siat/medidas',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var table = $("#<?php echo $tableID ?>").DataTable();
                        table.clear();
                        response.data.listaCodigos.forEach((item)=>{
                            table.row.add([
                                item.codigoClasificador,
                                item.descripcion
                            ]);
                        });
                        table.draw();
                    } else {
                        console.log('Error GET JSON');
                    }
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
                        <h1 class="card-title fw-bold mt-2">Sincronizar - Unidades de Medidas</h1>
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="sincronizeUnit()">
                                <i class="fas fa-sync"></i> Sincronizar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="<?php echo $tableID ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
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
