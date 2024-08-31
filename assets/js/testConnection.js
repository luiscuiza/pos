$(function() {
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
                    $('#sin-status').removeClass('badge-danger').addClass('badge-success').text('Conectado');
                } else {
                    $('#sin-status').removeClass('badge-success').addClass('badge-danger').text('Desconectado');
                }
            },
            error: function() {
                $('#sin-status').removeClass('badge-success').addClass('badge-danger').text('Desconectado');
            }
        });
    }
    checkConnection();
    setInterval(checkConnection, 3000);
});