<?php 
    $tableID = 'products';
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
                        <h1 class="card-title fw-bold mt-2">Productos</h1>
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="showForm('products','new')">
                                <i class="fas fa-box-open"></i> Nuevo Producto
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="<?php echo $tableID ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Imagen</th>
                                    <th>Disponible</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($product['cod_producto']) ?></td>
                                            <td><?= htmlspecialchars($product['nombre_producto']) ?></td>
                                            <td><?= htmlspecialchars($product['precio_producto']) ?></td>
                                            <td>
                                                <img src="/uploads/products/<?= htmlspecialchars($product['imagen_producto']) ?>" alt="Imagen del producto" style="width: 50px; height: 50px;">
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
                                                    <a class="btn edit btn-dark rounded-left" onclick="showForm('products', 'view', {'id':<?= $product['id_producto'] ?>})"><i class="fas fa-eye"></i></a>    
                                                    <a class="btn edit btn-dark" style="padding-right: 8px;" onclick="showForm('products','edit', {'id':<?= $product['id_producto'] ?>})"><i class="fas fa-edit"></i></a>
                                                    <a class="btn remove btn-dark rounded-right" onclick="deleteRecord('products',{'id':<?= $product['id_producto'] ?>})"><i class="fas fa-trash"></i></a>
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
