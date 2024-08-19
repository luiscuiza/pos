<div class="modal fade" id="newFacturaDialog" tabindex="-1" role="dialog" aria-labelledby="newFacturaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFacturaTitle">Nueva Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="reg-factura" enctype="multipart/form-data">
                    <!-- Código de Factura -->
                    <div class="form-group">
                        <label for="cod_factura">Código de Factura</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-file-invoice"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="cod_factura" name="cod_factura" placeholder="Código de la factura" required>
                        </div>
                    </div>
                    <!-- Cliente -->
                    <div class="form-group">
                        <label for="id_cliente">Cliente</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" id="id_cliente" name="id_cliente" placeholder="ID del Cliente" required>
                        </div>
                    </div>
                    <!-- ID Usuario -->
                    <div class="form-group">
                        <label for="id_usuario">Usuario</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" id="id_usuario" name="id_usuario" placeholder="ID del Usuario" required>
                        </div>
                    </div>
                    <!-- Usuario -->
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                        </div>
                    </div>
                    <!-- Punto de Venta -->
                    <div class="form-group">
                        <label for="id_punto_venta">Punto de Venta</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-store"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" id="id_punto_venta" name="id_punto_venta" placeholder="ID del Punto de Venta" required>
                        </div>
                    </div>
                    <!-- Neto -->
                    <div class="form-group">
                        <label for="neto">Neto</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" step="0.01" id="neto" name="neto" placeholder="Neto" required>
                        </div>
                    </div>
                    <!-- Descuento -->
                    <div class="form-group">
                        <label for="descuento">Descuento</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-percentage"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" step="0.01" id="descuento" name="descuento" placeholder="Descuento">
                        </div>
                    </div>
                    <!-- Total -->
                    <div class="form-group">
                        <label for="total">Total</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" step="0.01" id="total" name="total" placeholder="Total" required>
                        </div>
                    </div>
                    <!-- Fecha de Emisión -->
                    <div class="form-group">
                        <label for="fecha_emicion">Fecha de Emisión</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input class="form-control" type="datetime-local" id="fecha_emicion" name="fecha_emicion" required>
                        </div>
                    </div>
                    <!-- Detalle -->
                    <div class="form-group">
                        <label for="detalle">Detalle</label>
                        <textarea class="form-control" id="detalle" name="detalle" placeholder="Detalle de la factura" rows="3" required></textarea>
                    </div>
                    <!-- Leyenda -->
                    <div class="form-group">
                        <label for="leyenda">Leyenda</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-quote-right"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" id="leyenda" name="leyenda" placeholder="ID de la Leyenda" required>
                        </div>
                    </div>
                    <!-- CUF -->
                    <div class="form-group">
                        <label for="cuf">CUF</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="cuf" name="cuf" placeholder="Código CUF" required>
                        </div>
                    </div>
                    <!-- CUFD -->
                    <div class="form-group">
                        <label for="cufd">CUFD</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="cufd" name="cufd" placeholder="Código CUFD" required>
                        </div>
                    </div>
                    <!-- XML -->
                    <div class="form-group">
                        <label for="xml">XML</label>
                        <textarea class="form-control" id="xml" name="xml" placeholder="XML de la factura" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="width: 100px;" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" style="width: 100px;" onclick="$('#reg-factura').submit();">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $.validator.setDefaults({
        submitHandler: function() {
            registerFactura();
        }
    });
    $(function() {
        $('#reg-factura').validate({
            rules: {
                cod_factura: {
                    required: true,
                    minlength: 3
                },
                id_cliente: {
                    required: true,
                    number: true
                },
                detalle: {
                    required: true
                },
                neto: {
                    required: true,
                    number: true,
                    min: 0
                },
                descuento: {
                    number: true,
                    min: 0
                },
                total: {
                    required: true,
                    number: true,
                    min: 0
                },
                fecha_emicion: {
                    required: true,
                    date: true
                },
                cufd: {
                    required: true,
                    minlength: 10
                },
                cuf: {
                    required: true,
                    minlength: 10
                },
                xml: {
                    required: true
                },
                id_punto_venta: {
                    required: true,
                    number: true
                },
                id_usuario: {
                    required: true,
                    number: true
                },
                usuario: {
                    required: true,
                    minlength: 5
                },
                leyenda: {
                    required: true,
                    number: true
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
    });
</script>
