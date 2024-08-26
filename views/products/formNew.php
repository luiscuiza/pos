<div class="modal fade" id="products-new-dialog" tabindex="-1" role="dialog" aria-labelledby="newProductTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProductTitle">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="reg-producto" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Código -->
                            <div class="form-group">
                                <label for="codigo">Código Producto</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" type="text" id="codigo" name="codigo" placeholder="Código del producto" required>
                                </div>
                            </div>
                            <!-- Descripción -->
                            <div class="form-group">
                                <label for="nombre">Descripción</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre del producto" required>
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
                                    <input class="form-control" type="text" id="unidad_medida" name="unidad_medida" placeholder="Unidad de Medida" required>
                                </div>
                            </div>
                            <!-- Imagen -->
                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <span class="label-secondary">(Peso máximo 10MB - JPG, PNG)</span>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-image"></i>
                                        </span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imagen" name="imagen" accept="image/*" required>    
                                        <label class="custom-file-label label-secondary" for="imagen">Elegir archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Código SIN -->
                            <div class="form-group">
                                <label for="codigo_sin">Código SIN</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" type="number" id="codigo_sin" name="codigo_sin" placeholder="Código SIN" required>
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
                                    <input class="form-control" type="number" step="0.01" id="precio" name="precio" placeholder="Precio" required>
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
                                    <input class="form-control" type="number" id="unidad_medida_sin" name="unidad_medida_sin" placeholder="Unidad de Medida SIN" required>
                                </div>
                            </div>
                            <!-- Previsualización de Imagen -->
                            <div class="form-group">
                                <div class="mt-3">
                                    <div id="image-container" class="prev-image" style="text-align: center;">
                                        <img id="preview" src="#" alt="Previsualización" class="img-fluid prev-image" style="display:none;" />
                                        <i id="placeholder-icon" class="fas fa-box-open" style="font-size: 100px; color: #ccc;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="width: 100px;" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" style="width: 100px;" onclick="$('#reg-producto').submit();">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group-text {
        width: 40px !important;
    }
    .label-secondary {
        color: #9BA3A9;
    }
    .prev-image {
        width: 125px;
        height: 125px;
        max-width: 125px;
        max-height: 125px;
    }
</style>
<script>
    $.validator.setDefaults({
        submitHandler: function() {
            saveRecord('products','add','reg-producto');
        }
    });
    $(function() {
        $('#reg-producto').validate({
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
                    required: true,
                    extension: "png|jpg"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        $('#imagen').change(function() {
            const input = this;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result).show();
                    $('#placeholder-icon').hide();
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#preview').hide();
                $('#placeholder-icon').show();
            }
        });
    });


</script>