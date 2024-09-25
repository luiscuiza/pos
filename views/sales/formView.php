<?php
    $detalle = json_decode($sale['detalle'], true);
?>

<div class="modal fade" id="sales-view-dialog" tabindex="-1" role="dialog" aria-labelledby="viewSaleTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSaleTitle">Información de Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table">
                        <tr>
                            <th>Código Factura</th>
                            <td><?= $sale['codigo_factura'] ?></td>
                        </tr>
                        <tr>
                            <th>Cliente</th>
                            <td><?= $sale['razon_social_cliente'] ?></td>
                        </tr>
                        <tr>
                            <th>NIT/CI</th>
                            <td><?= $sale['nit_ci_cliente'] ?></td>
                        </tr>
                        <tr>
                            <th>Fecha</th>
                            <td><?= $sale['fecha_emicion'] ?></td>
                        </tr>
                        <tr>
                            <th>Emitido por</th>
                            <td><?= $sale['usario'] ?></td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>
                                <?php if ($sale['estado_factura']==1): ?>    
                                    <span class="badge badge-success">Emitido</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Cancelado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio (Bs)</th>
                                <th>Descuento (Bs)</th>
                                <th>SubTotal (Bs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($detalle)): ?>
                                <?php foreach ($detalle as $item): ?>
                                    <tr>
                                        <td><?= $item['descripcion'] ?></td>
                                        <td><?= $item['cantidad'] ?></td>
                                        <td><?= $item['precioUnitario'] ?></td>
                                        <td><?= $item['montoDescuento'] ?></td>
                                        <td><?= $item['subTotal'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold">Total</td>
                                <td><?= $sale['neto'] ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="width: 100px;" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
