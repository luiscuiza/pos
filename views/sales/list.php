<?php 
    $tableID = 'sales';
?>
<!-- HEAD CSS -->
<?php ob_start(); ?>
    <?php include 'views/layout/ListCss.php'; ?>
<?php $headCss = ob_get_clean(); ?>

<!-- BODY JS -->
<?php ob_start(); ?>
    <?php include 'views/layout/ListJs.php'; ?>
    <script src="/assets/js/crud.js"></script>
    <?php include 'views/layout/TableConfig.php'; ?>
<?php $bodyJs = ob_get_clean(); ?>

<section class="content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Facturas Emitidas</h1>
                    </div>
                    <div class="card-body">
                        <table id="<?php echo $tableID ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#Factura</th>
                                    <th>Cliente</th>
                                    <th>Emitido</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($sales)): ?>
                                    <?php foreach ($sales as $sale): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($sale['codigo_factura']) ?></td>
                                            <td><?= htmlspecialchars($sale['razon_social_cliente']) ?></td>
                                            <td><?= htmlspecialchars($sale['fecha_emicion']) ?></td>
                                            <td><?= htmlspecialchars($sale['total']) ?></td>
                                            <td>
                                                <?php if ($sale['estado_factura']): ?>
                                                    <span class="badge badge-success">Emitido</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Cancelado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn edit btn-dark rounded-left" onclick="showForm('sales', 'view', {'id':<?= $sale['id_factura'] ?>})"><i class="fas fa-eye"></i></a>    
                                                    <a class="btn remove btn-dark rounded-right" onclick="deleteRecord('sales',{'id': <?= $sale['id_factura'] ?>, 'cuf':'<?= $sale['cuf'] ?>'})"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>