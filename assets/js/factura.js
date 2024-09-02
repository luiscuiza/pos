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

function calcPreProd() {
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

var carrito = [];

function agregarCarrito() {
    let actEconomica = document.getElementById('actEconomica').value.trim();
    let codProducto = document.getElementById('codProducto').value.trim();
    let codProductoSin = parseInt(document.getElementById('codProductSin').value);
    let conceptoPro = document.getElementById('conceptoPro').value.trim();
    let cantProducto = parseInt(document.getElementById('cantProdcuto').value);
    let uniMedida = document.getElementById('uniMedida').value.trim();
    let uniMedidaSin = parseInt(document.getElementById('uniMedidaSin').value);
    let preUnitario = parseFloat(document.getElementById('preUnitario').value);
    let descProducto = parseFloat(document.getElementById('descProducto').value);
    let preTotal = parseFloat(document.getElementById('preTotal').value);

    let objDetalle = {
        actividadEconomica:actEconomica,
        codigoProductoSin:codProductoSin,
        codigoProducto:codProducto,
        descripcion:conceptoPro,
        cantidad:cantProducto,
        unidadMedida:uniMedidaSin,
        precioUnitario:preUnitario,
        montoDescuento:descProducto,
        subTotal:preTotal
    };

    carrito.push(objDetalle);
    
    drawTable();
    calcTotalFactura();

    document.getElementById('actEconomica').value='';
    document.getElementById('codProducto').value='';
    document.getElementById('codProductSin').value='';
    document.getElementById('conceptoPro').value='';
    document.getElementById('cantProdcuto').value=0;
    document.getElementById('uniMedida').value='';
    document.getElementById('uniMedidaSin').value='';
    document.getElementById('preUnitario').value=0;
    document.getElementById('descProducto').value=0;
    document.getElementById('preTotal').value=0;
}

function drawTable() {
    let table = document.getElementById('listaDetalle');
    table.innerHTML = '';
    carrito.forEach((detalle)=>{
        let row = table.insertRow();
        row.insertCell(0).innerHTML = `${detalle.descripcion}`;
        row.insertCell(1).innerHTML = `${detalle.cantidad}`;
        row.insertCell(2).innerHTML = `${detalle.precioUnitario}`;
        row.insertCell(3).innerHTML = `${detalle.montoDescuento}`;
        row.insertCell(4).innerHTML = `${detalle.subTotal}`;
        row.insertCell(5).innerHTML = `
            <a class="btn remove btn-dark rounded" onclick="eliminarCarrito('${detalle.codigoProducto}')"><i class="fas fa-trash"></i></a>
        `;
    });
}

function eliminarCarrito(cod) {
    carrito = carrito.filter((detalle)=>{
        if(cod !== detalle.codigoProducto) {
            return detalle
        }
    });
    drawTable();
    calcTotalFactura();
}

function calcTotalFactura() {
    let subtotal = 0.0;
    let descuento = 0.0;
    let total = 0.0;

    carrito.forEach(function(item) {
        let totalItem = parseFloat(item.precioUnitario * item.cantidad);
        subtotal += parseFloat(totalItem);
        descuento += parseFloat(item.montoDescuento);
        //total += parseFloat(item.subTotal);
    });
    total += parseFloat(subtotal-descuento)

    document.getElementById('subTotal').value = subtotal.toFixed(2);
    document.getElementById('descAdicional').value = descuento.toFixed(2);
    document.getElementById('totApagar').value = (subtotal - descuento).toFixed(2);
}

function emitirFactura() {
    let date = new Date();

    let numFactura = parseInt(document.getElementById('numFactura').value);
    let fechaFactura = date.toISOString();
    let rsCliente = document.getElementById('rsCliente').value;
    let tpDocumento = parseInt(document.getElementById('tpDocumento').value);
    let nitCliente = document.getElementById('nitCliente').value;
    let metPago = parseInt(document.getElementById('metPago').value);
    let totApagar = parseFloat(document.getElementById('totApagar').value);
    let descAdicional = parseFloat(document.getElementById('descAdicional').value);
    let subTotal = parseFloat(document.getElementById('subTotal').value);
    let usuarioLogin = document.querySelector('input[name="usuarioLoggin"]').value;
    let actEconomica = document.getElementById('actEconomica').value;
    let emailCliente = document.getElementById('emailCliente').value;

    var obj = {
        codigoAmbiente:2,
        codigoDocumentSector:1,
        codigoEmision:1,
        codigoModalidad:2,
        codigoSucursal:0,
        codigoPuntoVenta:0,
        codigoPuntoVentaSpecified:true,
        codigoSistema:codsys,
        cuis:cuis,
        cufd:cufd,
        nit:nit,
        tipoFacturaDocumento:1,
        archivo:null,
        fechaEnvio:fechaFactura,
        hashArchivo:'',
        codigoControl:'',
        factura: {
            cabecera:{
                nitEmisor: nit,
                razonSocialEmisor: rsEmpresa,
                municipio: 'Santa Cruz',
                telefono: telEmpresa,
                numeroFactura: numFactura,
                cuf:'String',
                cufd: cufd,
                codigoSucursal:0,
                direccion:dirEmpresa,
                codigoPuntoVenta:0,
                fechaEmision: fechaFactura,
                nombreRazonSolcial:rsCliente,
                codigoTipoDocumentoIdentidad: tpDocumento,
                numeroDocument:nitCliente,
                complemento:'',
                codigoCliente:nitCliente,
                codigoMetodoPago:metPago,
                numeroTarjeta:null,
                montoTotal, subtotal,
                montoTotalSujetoIva:totApagar,
                montoGiftCard:0,
                descuentoAdicional:descAdicional,
                codigoException:'0',
                calcf:null,
                leyenda:'',
                usuario:usuarioLogin,
                codigoDocumentSector:1,

            },
            detalle:carrito
        }
    };
}