var host='http://localhost:5000/';

var cufd;
var codControlCufd;
var fechaVigCufd;
var leyenda;

$(function() {

    function checkConnection() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${host}api/CompraVenta/comunicacion`,
                method: 'POST',
                data: "",
                cache: false,
                contentType: 'application/json',
                processData: false,
                success: function(response) {
                    if(response.transaccion) {
                        resolve();
                    } else {
                        reject();
                    }
                },
                error: function() {
                    reject();
                }
            });
        });
    }

    function checkCufdVigency() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: '/cufd/info',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        let now = new Date();
                        let vigencia = new Date(response.data.fecha_vigencia);
                        let expiracion = Math.floor((vigencia - now) / 1000);
                        if (expiracion > 0) {
                            resolve({
                                'cufd':response.data.codigo_cufd,
                                'control':response.data.codigo_control,
                                'vigencia':response.data.fecha_vigencia
                            });
                        } else {
                            reject();
                        }
                    } else {
                        reject();
                    }
                },
                error: function() {
                    reject();
                }
            });
        });
    }

    function requestNewCufd() {
        return new Promise((resolve, reject) => {
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
                    resolve({
                        'cufd':response.codigo,
                        'control':response.codigoControl,
                        'vigencia':response.fechaVigencia
                    });
                },
                error: function() {
                    reject();
                }
            });
        });
    }

    function saveCufd(data) {
        return new Promise((resolve, reject) => {
            var obj={
                'cufd':data.cufd,
                'control':data.control,
                'vigencia':data.vigencia
            };
            $.ajax({
                type: 'POST',
                data: obj,
                cache: false,
                url: '/cufd/save',
                success:function(response) {
                    if(response.status === 'success') {
                        resolve();
                    } else {
                        reject();
                    }
                },
                error: function() {
                    reject();
                }
            });
        });
    }

    function requestLeyenda() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: '/leyenda',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        resolve(response.data.desc_leyenda);
                    } else {
                        reject();
                    }
                },
                error: function() {
                    reject();
                }
            });
        });
    }

    /****************************/    

    function connectionStatus() {
        checkConnection()
            .then(() => {
                $('#sin-status').removeClass('badge-danger').addClass('badge-success').text("SIN - Conectado");
            })
            .catch(() => {
                $('#sin-status').removeClass('badge-success').addClass('badge-danger').text("SIN - Desconectado");
            })
            .finally(() => {
                setTimeout(connectionStatus, 5000);
            });
    }

    function cufdStatus() {
        checkCufdVigency().then((data) => {
            cufd = data.cufd;
            codControlCufd = data.control;
            fechaVigCufd = data.vigencia;
            $('#cufd-status').removeClass('badge-danger').addClass('badge-success').text('CUFD - Vigente');
        })
        .catch(() => {
            $('#cufd-status').removeClass('badge-success').addClass('badge-danger').text('CUFD - Caducado');
            requestNewCufd().then((data) => {
                saveCufd(data).then(() => {
                    cufd = data.cufd;
                    codControlCufd = data.control;
                    fechaVigCufd = data.vigencia;
                    $('#cufd-status').removeClass('badge-danger').addClass('badge-success').text('CUFD - Vigente');
                }).catch(() => {});
            }).catch(() => {});
        })
        .finally(() => {
            setTimeout(cufdStatus, 5000);
        });
    }

    function extraerLeyenda() {
        requestLeyenda()
            .then((descripcion)=>{
                leyenda = descripcion;
            })
            .catch(()=>{})
            .finally(()=>{
                setTimeout(extraerLeyenda, 5000);
            });
    }
    
    connectionStatus();
    cufdStatus();
    extraerLeyenda();
});