<?php 
    $tableID = 'facturas';
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
                        <h1 class="card-title fw-bold mt-2">Facturas</h1>
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="showForm('facturas','new')">
                                <i class="fas fa-file-invoice-dollar"></i> Nueva Factura
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="<?php echo $tableID ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código Factura</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Fecha Emisión</th>
                                    <th>Punto de Venta</th>
                                    <th>Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($facturas)): ?>
                                    <?php foreach ($facturas as $factura): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($factura['cod_factura']) ?></td>
                                            <td><?= htmlspecialchars($factura['id_cliente']) ?></td>
                                            <td><?= htmlspecialchars($factura['total']) ?></td>
                                            <td><?= htmlspecialchars($factura['fecha_emicion']) ?></td>
                                            <td><?= htmlspecialchars($factura['id_punto_venta']) ?></td>
                                            <td><?= htmlspecialchars($factura['usuario']) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn edit btn-dark rounded-left" onclick="showForm('facturas','edit',<?= htmlspecialchars($factura['id']) ?>)"><i class="fas fa-edit"></i></a>
                                                    <a class="btn remove btn-dark rounded-right" onclick="deleteRecord('facturas',<?= htmlspecialchars($factura['id']) ?>)"><i class="fas fa-trash"></i></a>
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
