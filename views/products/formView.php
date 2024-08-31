<?php
    $productId = $product['id_producto'];
    $codigo = $product['cod_producto'];
    $codigo_sin = $product['cod_producto_sin'];
    $nombre = $product['nombre_producto'];
    $precio = $product['precio_producto'];
    $unidad_medida = $product['unidad_medida'];
    $unidad_medida_sin = $product['unidad_medida_sin'];
    $imagen = $product['imagen_producto'];
    $disponible = $product['disponible'];
?>

<div class="modal fade" id="products-view-dialog" tabindex="-1" role="dialog" aria-labelledby="viewProductTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductTitle">Información del Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Código Producto</th>
                                <td><?php echo htmlspecialchars($codigo); ?></td>
                            </tr>
                            <tr>
                                <th>Código SIN</th>
                                <td><?php echo htmlspecialchars($codigo_sin); ?></td>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <td><?php echo htmlspecialchars($nombre); ?></td>
                            </tr>
                            <tr>
                                <th>Precio</th>
                                <td><?php echo htmlspecialchars($precio); ?></td>
                            </tr>
                            <tr>
                                <th>Unidad de Medida</th>
                                <td><?php echo htmlspecialchars($unidad_medida); ?></td>
                            </tr>
                            <tr>
                                <th>Unidad de Medida SIN</th>
                                <td><?php echo htmlspecialchars($unidad_medida_sin); ?></td>
                            </tr>
                            <tr>
                                <th>Disponibilidad</th>
                                <td>
                                    <?php if ($disponible): ?>    
                                        <span class="badge badge-success">Disponible</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">No Disponible</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <?php if ($imagen): ?> 
                            <img src="/uploads/products/<?php echo htmlspecialchars($imagen); ?>" alt="Imagen del producto" style="width: 100%; max-width: 300px; height: auto;">
                        <?php else: ?>
                            <i class="fas fa-image" style="font-size: 100px; color: #ccc;"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="width: 100px;" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
