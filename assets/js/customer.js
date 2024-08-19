// Mostrar formulario para crear un nuevo cliente
function showNewCustomer() {
    $.ajax({
        url: '/customers/new',
        method: 'GET',
        success: function(response) {
            $('#content-default').html(response);
            $('#modal-default').modal('show');
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar el formulario. Inténtalo nuevamente.',
            });
        }
    });
}

// Mostrar formulario para editar un cliente existente
function showEditCustomer(clientId) {
    $.ajax({
        url: '/customers/edit',
        method: 'GET',
        data: { id: clientId },
        success: function(response) {
            $('#content-default').html(response);
            $('#modal-default').modal('show');
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar el formulario de edición. Inténtalo nuevamente.',
            });
        }
    });
}

// Enviar solicitud para crear un nuevo cliente
function registerCustomer() {
    var formData = $('#reg-cliente').serialize();
    $.ajax({
        url: '/customers/add',
        method: 'POST',
        data: formData,
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'OK') {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message,
                }).then(function() {
                    location.reload(); // Recargar la página para actualizar la lista de clientes
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo crear el cliente. Inténtalo nuevamente.',
            });
        }
    });
}

// Enviar solicitud para editar un cliente existente
function editCustomer() {
    var formData = $('#edit-cliente').serialize();
    $.ajax({
        url: '/customers/edit',
        method: 'POST',
        data: formData,
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'OK') {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message,
                }).then(function() {
                    location.reload(); // Recargar la página para actualizar la lista de clientes
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el cliente. Inténtalo nuevamente.',
            });
        }
    });
}

// Enviar solicitud para eliminar un cliente
function showRemoveCustomer(clientId) {
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
                url: '/customers/remove',
                method: 'POST',
                data: { id: clientId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'OK') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: result.message,
                        }).then(function() {
                            location.reload(); // Recargar la página para actualizar la lista de clientes
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message,
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el cliente. Inténtalo nuevamente.',
                    });
                }
            });
        }
    });
}
