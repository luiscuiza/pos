<?php global $env; ?>

<?php ob_start(); ?>
    <script>
        var nit=<?= $env->get('nit') ?>;
        var rsEmpresa='<?= $env->get('razonsocial') ?>';
        var telEmpresa='<?= $env->get('phone') ?>';
        var dirEmpresa='<?= $env->get('address') ?>';
        var cuis='<?= $env->get('cuis') ?>';
        var codsys='<?= $env->get('codsys') ?>';
        var token='<?= $env->get('token') ?>';
    </script>
    <script src="/assets/js/testConnection.js"></script>
    <script src="/assets/js/factura.js"></script>
<?php $bodyJs = ob_get_clean(); ?>

<?php ob_start(); ?>
    <style>
        .remove:hover {
            border-color: #DC3545 !important;
            background-color: #DC3545 !important;
        }
        datalist {
            display: none;
        }
    </style>
<?php $headCss = ob_get_clean(); ?>



<section class="content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Emitir Factura</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-row">
                                    <!-- Numero Factura -->
                                    <div class="form-group col-md-6">
                                        <label for="numFactura">#Factura</label>
                                        <input type="number" class="form-control" name="numFactura" id="numFactura" value="<?= $nFactura ?>" readonly>
                                    </div>
                                    <!-- Actividad Economica -->
                                    <div class="form-group col-md-6">
                                        <label for="actEconomica">Actividad Economica</label>
                                        <select name="actEconomica" id="actEconomica" class="form-control">
                                            <option value="106140">Servicios de Comercio</option>
                                        </select>
                                    </div>
                                    <!-- Tipo de Documento -->
                                    <div class="form-group col-md-6">
                                        <label for="tpDocumento">Tipo de Documento</label>
                                        <select name="tpDocumento" id="tpDocumento" class="form-control">
                                            <option value="1">Ninguno</option>
                                            <option value="1">Cedula de Identidad</option>
                                            <option value="5">NIT</option>
                                        </select>
                                    </div>
                                    <!-- NIT/CI -->
                                    <div class="form-group col-md-6">
                                        <label for="nitCliente">NIT/CI</label>
                                        <div class="input-group">
                                            <input type="text" name="nitCliente" id="nitCliente" class="form-control" list="listaClientes">
                                            <div class="input-group-append">
                                                <button class="btn input-group-text" type="button" onclick="searchCustomer()">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <datalist id="listaClientes">
                                            <?php foreach ($customers as $customer): ?>
                                                <option value="<?= $customer['nit_ci_cliente'] ?>"><?= $customer['razon_social_cliente'] ?></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                    <!-- Razon Social -->
                                    <div class="form-group col-md-12">
                                        <label for="rsCliente">Razon Social</label>
                                        <input type="" class="form-control" name="rsCliente" id="rsCliente">
                                    </div>
                                    <!-- EMail -->
                                    <div class="form-group col-md-12">
                                        <label for="emailCliente">E-mail</label>
                                        <input type="email" class="form-control" name="emailCliente" id="emailCliente">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <!-- Subtotal -->
                                    <div class="form-group col-12">
                                        <label for="subTotal">Subtotal</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs.</span>
                                            </div>
                                            <input type="text" name="subTotal" id="subTotal" value="0.00" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Descuento -->
                                    <div class="form-group col-12">
                                        <label for="descAdicional">Descuento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs.</span>
                                            </div>
                                            <input type="text" name="descAdicional" id="descAdicional" value="0.00" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Total a Pagar -->
                                    <div class="form-group col-12">
                                        <label for="totApagar">Total a Pagar</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs.</span>
                                            </div>
                                            <input type="text" name="totApagar" id="totApagar" value="0.00" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <!-- Metodo de Pago -->
                                    <div class="form-group col-12">
                                        <label for="metPago">Metodo de Pago</label>
                                        <select name="metPago" id="metPago" class="form-control">
                                            <option value="1">Efectivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" onclick="emitirFactura()">Guardar</button>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Agregar Productos</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Cod. Producto -->
                            <div class="form-group col-md-6">
                                <label for="codProducto">Cod. Producto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="codProducto" id="codProducto" list="listaProductos">
                                    <input type="hidden" id="codProductSin">
                                    <div class="input-group-append">
                                        <button class="btn input-group-text" type="button" onclick="searchProduct()">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <datalist id="listaProductos">
                                    <?php foreach ($productos as $producto): ?>
                                        <option value="<?= $producto['cod_producto'] ?>"><?= $producto['nombre_producto'] ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <!-- Concepto -->
                            <div class="form-group col-md-6">
                                <label for="conceptoPro">Concepto</label>
                                <input type="text" class="form-control" name="conceptoPro" id="conceptoPro">
                            </div>
                            <!-- U. Medida -->
                            <div class="form-group col-md-2">
                                <label for="uniMedida">U. Medida</label>
                                <input type="text" class="form-control" name="uniMedida" id="uniMedida" readonly>
                                <input type="text" id="uniMedidaSin" hidden>
                            </div>
                            <!-- Cantidad -->
                            <div class="form-group col-md-2">
                                <label for="cantProdcuto">Cantidad</label>
                                <input type="number" class="form-control" name="cantProdcuto" id="cantProdcuto" value="0" onkeyup="calcPreProd()">
                            </div>
                            <!-- P. Unitario -->
                            <div class="form-group col-md-2">
                                <label for="preUnitario">P. Unitario</label>
                                <input type="number" class="form-control" name="preUnitario" id="preUnitario" readonly>
                            </div>
                            <!-- Descuento -->
                            <div class="form-group col-md-2">
                                <label for="descProducto">Descuento</label>
                                <input type="number" class="form-control" name="descProducto" id="descProducto" value="0" onkeyup="calcPreProd()">
                            </div>
                            <!-- P. Total -->
                            <div class="form-group col-md-2">
                                <label for="preTotal">P. Total</label>
                                <input type="number" class="form-control" name="preTotal" id="preTotal" value="0" readonly>
                            </div>
                            <div class="form-group d-flex align-items-end ">
                                <button class="btn btn-success form-control w-100" onclick="agregarCarrito()"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Descripción</td>
                                        <td>Cantidad</td>
                                        <td>P. Unitario</td>
                                        <td>Descuento</td>
                                        <td>P. Total</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </thead>
                                <tbody id="listaDetalle">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


                        