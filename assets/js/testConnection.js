var host='http://localhost:5000/';

var cufd;
var codControlCufd;
var fechaVigCufd;

var isCheckingCufdVigency = false;

$(function() {

    function requestCufd() {
        var obj = {
            codigoAmbiente: 2,
            codigoModalidad: 2,
            codigoPuntoVenta: 0,
            codigoPuntoVentaSpecified: true,
            codigoSistema: codsys,
            codigoSucursal: 0,
            nit: nit,
            cuis:cuis
        };
        $.ajax({
            type: 'POST',
            url: `${host}api/Codigos/solicitudCufd?token=${token}`,
            data:JSON.stringify(obj),
            cache: false,
            dataType:'json',
            contentType: 'application/json',
            success:function(response) {
                cufd=response.codigo;
                codControlCufd=response.codigoControl;
                fechaVigCufd=response.fechaVigencia;
            }
        });
    }
    
    function registrarNuevoCufd() {
        var obj={
            'cufd':cufd,
            'vigencia':fechaVigCufd,
            'control':codControlCufd,
        }
        console.log(obj);
        $.ajax({
            type: 'POST',
            data: obj,
            cache: false,
            url: '/cufd/save',
            success:function(response) {
                if(response.status == 'success') {
                    $('#cufd-status').removeClass('badge-danger').addClass('badge-success').text('CUDF - Vigente');
                } else {
                    $('#cufd-status').removeClass('badge-success').addClass('badge-danger').text('CUFD - Caducado');
                }
            }
        });
    }

    function checkConnection() {
        var obj = "";
        $.ajax({
            url: 'http://localhost:5000/api/CompraVenta/comunicacion',
            method: 'POST',
            data: obj,
            cache:false,
            contentType: 'application/json',
            processData: false,
            success: function(response) {
                if(response.transaccion) {
                    $('#sin-status').removeClass('badge-danger').addClass('badge-success').text('SIN - Conectado');
                } else {
                    $('#sin-status').removeClass('badge-success').addClass('badge-danger').text('SIN - Desconectado');
                }
            },
            error: function() {
                $('#sin-status').removeClass('badge-success').addClass('badge-danger').text('Desconectado');
            }
        });
    }
    
    function checkCufdVigency() {
        if (isCheckingCufdVigency) {
            return;
        }
        isCheckingCufdVigency = true;
        $.ajax({
            type: 'GET',
            url: '/cufd/info',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    cufd = response.data.codigo_cufd;
                    codControlCufd = response.data.codigo_control;
                    fechaVigCufd = response.data.fecha_vigencia;
                    var now = new Date();
                    var vigencia = new Date(response.data.fecha_vigencia);
                    var expiracion = Math.floor((vigencia - now) / 1000);
                    if (expiracion <= 0) {
                        requestCufd();
                        registrarNuevoCufd();
                    } else {
                        $('#cufd-status').removeClass('badge-danger').addClass('badge-success').text('CUDF - Vigente');
                    }
                } else if (response.status === 'no_data') {
                    requestCufd();
                    registrarNuevoCufd();
                } else {
                    console.log("Error: " + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            },
            complete: function() {
                isCheckingCufdVigency = false;
            }
        });
    }
    
    checkConnection();
    checkCufdVigency();
    setInterval(checkConnection, 5000);
    setInterval(checkCufdVigency, 10000);
});