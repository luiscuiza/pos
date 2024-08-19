<!-- HEAD CSS -->
<?php ob_start(); ?>
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<?php $headCss = ob_get_clean(); ?>

<!-- BODY JS -->
<?php ob_start(); ?>
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="/assets/plugins/jquery-validation/localization/messages_es.js"></script>
    <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="/assets/js/customer.js"></script>
    <script>
        $(function () {
            $("#customers").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [
                    { extend: 'excel',  text: 'Excel'},
                    { extend: 'pdf',    text: 'PDF'},
                    { extend: 'print',  text: 'Imprimir'},
                    { extend: 'colvis', text: 'Columnas'}
                ],
                "language": {
                    "oPaginate": {
                        "sFirst":    "<<",
                        "sLast":     ">>",
                        "sNext":     ">",
                        "sPrevious": "<"
                    }
                }
            }).buttons().container().appendTo('#customers_wrapper .col-md-6:eq(0)');
        });
    </script>
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
                        <table id="customers" class="table table-bordered table-striped">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal-default">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="content-default">
        </div>
    </div>
</div>
