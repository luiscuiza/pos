$(function() {

    function checkConnection() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: '/siat/connected',
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        resolve();
                    } else {
                        reject(new Error(response.message));
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    reject(new Error(textStatus));
                }
            });
        });
    }

    function checkCufdVigency() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: '/siat/cufd/valid',
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        resolve();
                    } else {
                        reject(new Error(response.message));
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    reject(new Error(textStatus));
                }
            });
        });
    }

    function regenerateCufd() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: '/siat/cufd/renew',
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        resolve();
                    } else {
                        reject(new Error(response.message));
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    reject(new Error(textStatus));
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
                error: function(jqXHR, textStatus, errorThrown) {
                    reject(new Error(`Error en la conexión: ${textStatus} - ${errorThrown}`));
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
            .catch( error => {
                $('#sin-status').removeClass('badge-success').addClass('badge-danger').text("SIN - Desconectado");
            })
            .finally(() => {
                setTimeout(connectionStatus, 5000);
            });
    }

    function cufdStatus() {
        checkCufdVigency().then(() => {
            $('#cufd-status').removeClass('badge-danger').addClass('badge-success').text('CUFD - Vigente');
        })
        .catch( error => {
            $('#cufd-status').removeClass('badge-success').addClass('badge-danger').text('CUFD - Caducado');
            regenerateCufd().then((data) => {
                saveCufd(data).then(() => {
                    $('#cufd-status').removeClass('badge-danger').addClass('badge-success').text('CUFD - Vigente');
                }).catch(() => {});
            }).catch( error => {
            });
        })
        .finally( () => {
            setTimeout(cufdStatus, 5000);
        });
    }

    function extraerLeyenda() {
        requestLeyenda()
            .then((descripcion)=>{
                leyenda = descripcion;
            })
            .catch( error => {
            })
            .finally(()=>{
                setTimeout(extraerLeyenda, 5000);
            });
    }
    
    connectionStatus();
    cufdStatus();
    extraerLeyenda();
});