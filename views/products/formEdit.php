<?php
    // Asignar los valores del producto a variables para su uso en el formulario
    $productId = $product['id'];
    $codigo = $product['codigo'];
    $codigo_sin = $product['codigo_sin'];
    $nombre = $product['nombre'];
    $precio = $product['precio'];
    $unidad_medida = $product['unidad_medida'];
    $unidad_medida_sin = $product['unidad_medida_sin'];
    $imagen = $product['imagen'];
    $disponible = $product['disponible'];
?>

<div class="modal fade" id="editProductDialog" tabindex="-1" role="dialog" aria-labelledby="editProductTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductTitle">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-producto" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $productId; ?>">
                    <!-- Disponible -->
                    <div class="form-group">
                        <label for="disponible">Disponible</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-toggle-on"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center switch-container">
                                <label class="switch my-1 px-1">
                                    <input type="checkbox" id="disponible" name="disponible" value="1" <?php echo $disponible ? 'checked' : ''; ?> onchange="toggleStatusSwitch(this, 'Disponible', 'No Disponible')">
                                    <span class="slider"></span>
                                </label>
                                <span class="status-label <?php echo $disponible ? 'label-status-active' : 'label-status-inactive'; ?>">
                                    <?php echo $disponible ? 'Disponible' : 'No Disponible'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Código -->
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-barcode"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="codigo" name="codigo" placeholder="Código del producto" 
                                   value="<?php echo htmlspecialchars($codigo); ?>" required>
                        </div>
                    </div>
                    <!-- Código SIN -->
                    <div class="form-group">
                        <label for="codigo_sin">Código SIN</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-barcode"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" id="codigo_sin" name="codigo_sin" placeholder="Código SIN" 
                                   value="<?php echo htmlspecialchars($codigo_sin); ?>" required>
                        </div>
                    </div>
                    <!-- Nombre -->
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-tag"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre del producto" 
                                   value="<?php echo htmlspecialchars($nombre); ?>" required>
                        </div>
                    </div>
                    <!-- Precio -->
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" step="0.01" id="precio" name="precio" placeholder="Precio" 
                                   value="<?php echo htmlspecialchars($precio); ?>" required>
                        </div>
                    </div>
                    <!-- Unidad de Medida -->
                    <div class="form-group">
                        <label for="unidad_medida">Unidad de Medida</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-balance-scale"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="unidad_medida" name="unidad_medida" placeholder="Unidad de Medida" 
                                   value="<?php echo htmlspecialchars($unidad_medida); ?>" required>
                        </div>
                    </div>
                    <!-- Unidad de Medida SIN -->
                    <div class="form-group">
                        <label for="unidad_medida_sin">Unidad de Medida SIN</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-balance-scale"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" id="unidad_medida_sin" name="unidad_medida_sin" placeholder="Unidad de Medida SIN" 
                                   value="<?php echo htmlspecialchars($unidad_medida_sin); ?>" required>
                        </div>
                    </div>
                    <!-- Imagen -->
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-image"></i>
                                </span>
                            </div>
                            <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <?php if ($imagen): ?> 
                            <img src="/uploads/products/<?php echo htmlspecialchars($imagen); ?>" alt="Imagen del producto" style="width: 100px; height: 100px;">
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="width: 100px;" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" style="width: 100px;" onclick="$('#edit-producto').submit();">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $.validator.setDefaults({
        submitHandler: function () {
            editProduct();
        }
    });

    $(function () {
        $('#edit-producto').validate({
            rules: {
                codigo: {
                    required: true,
                    minlength: 3
                },
                codigo_sin: {
                    required: true,
                    number: true
                },
                nombre: {
                    required: true,
                    minlength: 3
                },
                precio: {
                    required: true,
                    number: true,
                    min: 0
                },
                unidad_medida: {
                    required: true,
                    minlength: 2
                },
                unidad_medida_sin: {
                    required: true,
                    number: true
                },
                imagen: {
                    extension: "jpg|jpeg|png|gif"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
