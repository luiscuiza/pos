<?php
    $facturaId = $factura['id'];
    $cod_factura = $factura['cod_factura'];
    $id_cliente = $factura['id_cliente'];
    $detalle = $factura['detalle'];
    $neto = $factura['neto'];
    $descuento = $factura['descuento'];
    $total = $factura['total'];
    $fecha_emicion = $factura['fecha_emicion'];
    $cufd = $factura['cufd'];
    $cuf = $factura['cuf'];
    $xml = $factura['xml'];
    $id_punto_venta = $factura['id_punto_venta'];
    $id_usuario = $factura['id_usuario'];
    $usuario = $factura['usuario'];
    $leyenda = $factura['leyenda'];
?>

<div class="modal fade" id="facturas-edit-dialog" tabindex="-1" role="dialog" aria-labelledby="editFacturaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFacturaTitle">Editar Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="edit-factura" enctype="multipart/form-data">
                    <!-- Campo oculto para el ID de la Factura -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($facturaId); ?>">

                    <!-- Código de Factura -->
                    <div class="form-group">
                        <label for="cod_factura">Código de Factura</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-file-invoice"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" id="cod_factura" name="cod_factura" value="<?php echo htmlspecialchars($cod_factura); ?>" placeholder="Código de la factura" required>
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
                            <input class="form-control" type="number" id="id_cliente" name="id_cliente" value="<?php echo htmlspecialchars($id_cliente); ?>" placeholder="ID del Cliente" required>
                        </div>
                    </div>
                    <!-- ID Usuario -->
                    <div class="form-group">
                        <label for="id_usuario">ID Usuario</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="number" id="id_usuario" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>" placeholder="ID del Usuario" required>
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
                            <input class="form-control" type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>" placeholder="Usuario" required>
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
                            <input class="form-control" type="number" id="id_punto_venta" name="id_punto_venta" value="<?php echo htmlspecialchars($id_punto_venta); ?>" placeholder="ID del Punto de Venta" required>
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
                            <input class="form-control" type="number" step="0.01" id="neto" name="neto" value="<?php echo htmlspecialchars($neto); ?>" placeholder="Neto" required>
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
                            <input class="form-control" type="number" step="0.01" id="descuento" name="descuento" value="<?php echo htmlspecialchars($descuento); ?>" placeholder="Descuento">
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
                            <input class="form-control" type="number" step="0.01" id="total" name="total" value="<?php echo htmlspecialchars($total); ?>" placeholder="Total" required>
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
                            <input class="form-control" type="datetime-local" id="fecha_emicion" name="fecha_emicion" value="<?php echo htmlspecialchars($fecha_emicion); ?>" required>
                        </div>
                    </div>
                    <!-- Detalle -->
                    <div class="form-group">
                        <label for="detalle">Detalle</label>
                        <textarea class="form-control" id="detalle" name="detalle" placeholder="Detalle de la factura" rows="3" required><?php echo htmlspecialchars($detalle); ?></textarea>
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
                            <input class="form-control" type="number" id="leyenda" name="leyenda" value="<?php echo htmlspecialchars($leyenda); ?>" placeholder="ID de la Leyenda" required>
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
                            <input class="form-control" type="text" id="cuf" name="cuf" value="<?php echo htmlspecialchars($cuf); ?>" placeholder="Código CUF" required>
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
                            <input class="form-control" type="text" id="cufd" name="cufd" value="<?php echo htmlspecialchars($cufd); ?>" placeholder="Código CUFD" required>
                        </div>
                    </div>
                    <!-- XML -->
                    <div class="form-group">
                        <label for="xml">XML</label>
                        <textarea class="form-control" id="xml" name="xml" placeholder="XML de la factura" rows="3" required><?php echo htmlspecialchars($xml); ?></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="width: 100px;" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" style="width: 100px;" onclick="$('#edit-factura').submit();">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $.validator.setDefaults({
        submitHandler: function() {
            saveRecord('facturas','edit','edit-factura');
        }
    });
    $(function() {
        $('#edit-factura').validate({
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
