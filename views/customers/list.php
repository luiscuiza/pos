<?php 
    $tableID = 'customers';
?>
<!-- HEAD CSS -->
<?php ob_start(); ?>
    <?php include 'views/layout/ListCss.php'; ?>
<?php $headCss = ob_get_clean(); ?>

<!-- BODY JS -->
<?php ob_start(); ?>
    <?php include 'views/layout/ListJs.php'; ?>
    <script src="/assets/js/customer.js"></script>
    <?php include 'views/layout/TableConfig.php'; ?>
<?php $bodyJs = ob_get_clean(); ?>

<section class="content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Clientes</h1>
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="showNewCustomer()">
                                <i class="fas fa-user-plus"></i> Nuevo Cliente 
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="<?php echo $tableID ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Razón Social</th>
                                    <th>NIT / CI</th>
                                    <th>Dirección</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($customers)): ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($customer['razon_social']) ?></td>
                                            <td><?= htmlspecialchars($customer['nit_ci']) ?></td>
                                            <td><?= htmlspecialchars($customer['direccion']) ?></td>
                                            <td><?= htmlspecialchars($customer['nombre']) ?></td>
                                            <td><?= htmlspecialchars($customer['telefono']) ?></td>
                                            <td><?= htmlspecialchars($customer['email']) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn edit btn-dark rounded-left" style="padding-right: 8px;" onclick="showEditCustomer(<?= htmlspecialchars($customer['id']) ?>)"><i class="fas fa-edit"></i></a>
                                                    <a class="btn remove btn-dark rounded-right" onclick="showRemoveCustomer(<?= htmlspecialchars($customer['id']) ?>)"><i class="fas fa-trash"></i></a>
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
