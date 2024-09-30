function searchCustomer() {
    let nit = document.getElementById('nitCliente').value;
    if(nit.trim() !== "") {
        var obj = {
            'nit':nit
        };
        $.ajax({
            url: '/customers/info',
            method: 'POST',
            data: JSON.stringify(obj),
            dataType: "json",
            contentType: 'application/json',
            success: function(response) {
                if(response.data) {
                    document.getElementById('idCliente').value = response.data.id_cliente;
                    document.getElementById('rsCliente').value = response.data.razon_social_cliente;
                    document.getElementById('emailCliente').value = response.data.email_cliente;
                }
            }
        });
    }   
}

function searchProduct() {
    let codprod = document.getElementById('codProducto').value;
    if(codprod.trim() !== "") {
        var obj = {
            'codprod':codprod
        };
        $.ajax({
            url: '/products/info',
            method: 'POST',
            data: JSON.stringify(obj),
            dataType: "json",
            contentType: 'application/json',
            success: function(response) {
                if(response.data) {
                    document.getElementById('conceptoPro').value = response.data.nombre_producto;
                    document.getElementById('uniMedida').value = response.data.unidad_medida;
                    document.getElementById('preUnitario').value = response.data.precio_producto;
                    document.getElementById('codProductSin').value = response.data.cod_producto_sin;
                    document.getElementById('uniMedidaSin').value = response.data.unidad_medida_sin;
                }
            }
        });
    }   
}

function fillCartTable(cart, totales) {
    let table = document.getElementById('listaDetalle');
    table.innerHTML = '';
    Object.entries(cart).forEach(([key, detalle]) => {
        let row = table.insertRow();
        row.insertCell(0).innerHTML = `${detalle.descripcion}`;
        row.insertCell(1).innerHTML = `${detalle.cantidad}`;
        row.insertCell(2).innerHTML = `${detalle.precioUnitario.toFixed(2)}`;
        row.insertCell(3).innerHTML = `${detalle.montoDescuento.toFixed(2)}`;
        row.insertCell(4).innerHTML = `${detalle.subTotal.toFixed(2)}`;
        row.insertCell(5).innerHTML = `
            <a class="btn remove btn-dark rounded" onclick="eliminarCarrito('${key}')"><i class="fas fa-trash"></i></a>
        `;
    });
    document.getElementById('subTotal').value = totales.neto.toFixed(2);
    document.getElementById('descAdicional').value = totales.descuento.toFixed(2);
    document.getElementById('totApagar').value = totales.total.toFixed(2);
}

function agregarCarrito() {
    let actividadEconomica = document.getElementById('actEconomica').value.trim();
    let codigoProductoSin = parseInt(document.getElementById('codProductSin').value);
    let codigoProducto = document.getElementById('codProducto').value.trim();
    let descripcion = document.getElementById('conceptoPro').value.trim();
    let cantidad = parseInt(document.getElementById('cantProdcuto').value);
    let unidadMedida = document.getElementById('uniMedida').value.trim();
    let unidadMedidaSin = parseInt(document.getElementById('uniMedidaSin').value);
    let precioUnitario = parseFloat(document.getElementById('preUnitario').value);
    let montoDescuento = parseFloat(document.getElementById('descProducto').value);

    if (!actividadEconomica || isNaN(codigoProductoSin) || !codigoProducto || !descripcion || isNaN(cantidad) || !unidadMedida || isNaN(unidadMedidaSin) || isNaN(precioUnitario) || isNaN(montoDescuento)) {
        return;
    }

    if (cantidad <= 0 || precioUnitario <= 0) {
        return;
    }

    let detalle = {
        actividadEconomica: actividadEconomica,
        codigoProductoSin: codigoProductoSin,
        codigoProducto: codigoProducto,
        descripcion: descripcion,
        cantidad: cantidad,
        unidadMedida: unidadMedida,
        unidadMedidaSin: unidadMedidaSin,
        precioUnitario: precioUnitario,
        montoDescuento: montoDescuento,
    };

    document.getElementById('codProducto').value = '';
    document.getElementById('codProductSin').value = '';
    document.getElementById('conceptoPro').value = '';
    document.getElementById('cantProdcuto').value = 0;
    document.getElementById('uniMedida').value = '';
    document.getElementById('uniMedidaSin').value = '';
    document.getElementById('preUnitario').value = 0;
    document.getElementById('descProducto').value = 0;
    document.getElementById('preTotal').value = 0;

    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: JSON.stringify(detalle),
        dataType: "json",
        contentType: 'application/json',
        success: function(response) {
            if (response.success) {
                let cart = response.data.cart;
                let totales = response.data.totales;
                fillCartTable(cart, totales);
            }
        },
        error: function(e) {
            console.log(e);
        }
    });
}

function eliminarCarrito(uuid) {
    $.ajax({
        url: '/cart/remove',
        method: 'POST',
        data: JSON.stringify({
            'uuid': uuid
        }),
        dataType: "json",
        contentType: 'application/json',
        success: function(response) {
            if (response.success) {
                let cart = response.data.cart;
                let totales = response.data.totales;
                fillCartTable(cart, totales);
            }
        }
    });
}

function limpiarCarrito() {
    $.ajax({
        url: '/cart/clear',
        method: 'POST',
        dataType: "json",
        contentType: 'application/json'        
    }).always(function() {
        location.reload();
    });;
}

function prevTotal() {
    let pu = document.getElementById('preUnitario').value;
    let cant = document.getElementById('cantProdcuto').value;
    let desc = document.getElementById('descProducto').value;
    if (pu !== '' && !isNaN(pu) && cant !== '' && !isNaN(cant) && desc !== '' && !isNaN(desc)) {
        pu = parseFloat(pu);
        cant = parseFloat(cant);
        desc = parseFloat(desc);
        let total = pu * cant;
        let totalConDescuento = total - desc;
        totalConDescuento = Math.max(0, totalConDescuento);
        document.getElementById('preTotal').value = totalConDescuento.toFixed(2);
    }
}

function emitirFactura() {
    
    function validarFactura() {
        let numFactura = document.getElementById('numFactura').value;
        let nitCliente = document.getElementById('nitCliente').value;
        let emailCliente = document.getElementById('emailCliente').value;
        let rsCliente = document.getElementById('rsCliente').value;
        let idCliente = document.getElementById('idCliente').value;
        let tpDocumento =  document.getElementById('tpDocumento').value;
        if (!numFactura || isNaN(numFactura) || !nitCliente || isNaN(nitCliente) || !emailCliente || !rsCliente || !idCliente || !tpDocumento) {
            return false;
        }
        if (document.querySelector('#listaDetalle td[colspan="6"]') || document.getElementById('listaDetalle').rows.length == 0) {
            return false;
        }
        return true;
    }

    if(!validarFactura()) {
        Swal.fire({
            timer: 3000,
            icon: 'warning',
            title: 'Factura',
            text: 'Asegurese de llenar todos los campos faltantes!',
        });
        return;
    }

    let data = {
        'fechaFactura': new Date().toISOString(),
        'idCliente': parseInt(document.getElementById('idCliente').value), 
        'numFactura': parseInt(document.getElementById('numFactura').value), 
        'rsCliente': document.getElementById('rsCliente').value,
        'tpDocumento': parseInt(document.getElementById('tpDocumento').value), 
        'nitCliente': document.getElementById('nitCliente').value,
        'metPago': parseInt(document.getElementById('metPago').value),
        'actEconomica': document.getElementById('actEconomica').value,
        'emailCliente': document.getElementById('emailCliente').value,
        'leyenda':leyenda
    }

    $.ajax({
        type: 'POST',
        url: '/sales/emit',
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    timer: 2500,
                    icon: 'success',
                    title: 'Factura',
                    text: 'La factura se registro correctamente'
                }).then(function() {
                    location.reload();
                });
            } else {
                Swal.fire({
                    timer: 3000,
                    icon: 'error',
                    title: 'Error de conexión',
                    text: response.message,
                });                
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                timer: 3000,
                icon: 'error',
                title: 'Error de conexión',
                text: `No se pudo emitir la factura: ${textStatus} - ${errorThrown}`,
            });
        }
    });
}
