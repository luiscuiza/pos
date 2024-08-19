<!-- HEAD CSS -->
<?php ob_start(); ?>
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="/assets/css/switchbutton.css">
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
    <script src="/assets/js/switchbutton.js"></script>
    <script src="/assets/js/products.js"></script>
    <script>
        $(function () {
            $("#products").DataTable({
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
            }).buttons().container().appendTo('#products_wrapper .col-md-6:eq(0)');
        });
    </script>
<?php $bodyJs = ob_get_clean(); ?>

<section class="content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Productos</h1>
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="showNewProduct()">
                                <i class="fas fa-box-open"></i> Nuevo Producto
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Código SIN</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Unidad de Medida</th>
                                    <th>Unidad de Medida SIN</th>
                                    <th>Imagen</th>
                                    <th>Disponible</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($product['codigo']) ?></td>
                                            <td><?= htmlspecialchars($product['codigo_sin']) ?></td>
                                            <td><?= htmlspecialchars($product['nombre']) ?></td>
                                            <td><?= htmlspecialchars($product['precio']) ?></td>
                                            <td><?= htmlspecialchars($product['unidad_medida']) ?></td>
                                            <td><?= htmlspecialchars($product['unidad_medida_sin']) ?></td>
                                            <td>
                                                <img src="/uploads/products/<?= htmlspecialchars($product['imagen']) ?>" alt="Imagen del producto" style="width: 50px; height: 50px;">
                                            </td>
                                            <td>
                                                <?php if ($product['disponible']): ?>
                                                    <span class="badge badge-success">Disponible</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">No Disponible</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn edit btn-dark rounded-left" style="padding-right: 8px;" onclick="showEditProduct(<?= htmlspecialchars($product['id']) ?>)"><i class="fas fa-edit"></i></a>
                                                    <a class="btn remove btn-dark rounded-right" onclick="showRemoveProduct(<?= htmlspecialchars($product['id']) ?>)"><i class="fas fa-trash"></i></a>
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
