<!-- HEAD CSS -->
<?php ob_start(); ?>
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <style>
        .edit:hover {
            border-color: #007BFF !important;
            background-color: #007BFF !important;
        }
        .remove:hover {
            border-color: #DC3545 !important;
            background-color: #DC3545 !important;
        }
    </style>
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
    <script src="/assets/js/facturas.js"></script>
    <script>
        $(function () {
            $("#facturas").DataTable({
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
            }).buttons().container().appendTo('#facturas_wrapper .col-md-6:eq(0)');
        });
    </script>
<?php $bodyJs = ob_get_clean(); ?>

<section class="content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Facturas</h1>
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="showNewFactura()">
                                <i class="fas fa-file-invoice-dollar"></i> Nueva Factura
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="facturas" class="table table-bordered table-striped">
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
                                                    <a class="btn edit btn-dark rounded-left" onclick="showEditFactura(<?= htmlspecialchars($factura['id']) ?>)"><i class="fas fa-edit"></i></a>
                                                    <a class="btn remove btn-dark rounded-right" onclick="showRemoveFactura(<?= htmlspecialchars($factura['id']) ?>)"><i class="fas fa-trash"></i></a>
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