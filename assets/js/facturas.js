// Mostrar formulario para crear una nueva factura
function showNewFactura() {
    $.ajax({
        url: '/facturas/new',
        method: 'GET',
        success: function(response) {
            $('#newFacturaDialog').remove();
            $('body').append(response);
            $('#newFacturaDialog').modal('show');
            $('#newFacturaDialog').on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                timer: 2500,
                text: 'No se pudo cargar el formulario. Inténtalo nuevamente.',
            });
        }
    });
}

// Mostrar formulario para editar una factura existente
function showEditFactura(facturaId) {
    $.ajax({
        url: '/facturas/edit',
        method: 'GET',
        data: { id: facturaId },
        success: function(response) {
            $('#editFacturaDialog').remove();
            $('body').append(response);
            $('#editFacturaDialog').modal('show');
            $('#editFacturaDialog').on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                timer: 2500,
                text: 'No se pudo cargar el formulario de edición. Inténtalo nuevamente.',
            });
        }
    });
}

// Enviar solicitud para crear una nueva factura
function registerFactura() {
    var formData = new FormData($('#reg-factura')[0]);
    $.ajax({
        url: '/facturas/add',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'OK') {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    timer: 2500,
                    text: result.message,
                }).then(function() {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    timer: 2500,
                    text: result.message,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                timer: 2500,
                text: 'No se pudo crear la factura. Inténtalo nuevamente.',
            });
        }
    });
}

// Enviar solicitud para editar una factura existente
function editFactura() {
    var formData = new FormData($('#edit-factura')[0]);
    $.ajax({
        url: '/facturas/edit',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'OK') {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    timer: 2500,
                    text: result.message,
                }).then(function() {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    timer: 2500,
                    text: result.message,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                timer: 2500,
                text: 'No se pudo actualizar la factura. Inténtalo nuevamente.',
            });
        }
    });
}

// Enviar solicitud para eliminar una factura
function showRemoveFactura(facturaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/facturas/remove',
                method: 'POST',
                data: { id: facturaId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'OK') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            timer: 2500,
                            text: result.message,
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            timer: 2500,
                            text: result.message,
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        timer: 2500,
                        text: 'No se pudo eliminar la factura. Inténtalo nuevamente.',
                    });
                }
            });
        }
    });
}
