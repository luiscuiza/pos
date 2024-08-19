// Mostrar formulario para crear un nuevo producto
function showNewProduct() {
    $.ajax({
        url: '/products/new',
        method: 'GET',
        success: function(response) {
            $('#newProductDialog').remove();
            $('body').append(response);
            $('#newProductDialog').modal('show');
            $('#newProductDialog').on('hidden.bs.modal', function () {
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

// Mostrar formulario para editar un producto existente
function showEditProduct(productId) {
    $.ajax({
        url: '/products/edit',
        method: 'GET',
        data: { id: productId },
        success: function(response) {
            $('#editProductDialog').remove();
            $('body').append(response);
            $('#editProductDialog').modal('show');
            $('#editProductDialog').on('hidden.bs.modal', function () {
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

// Enviar solicitud para crear un nuevo producto
function registerProduct() {
    var formData = new FormData($('#reg-producto')[0]);
    $.ajax({
        url: '/products/add',
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
                text: 'No se pudo crear el producto. Inténtalo nuevamente.',
            });
        }
    });
}

// Enviar solicitud para editar un producto existente
function editProduct() {
    var formData = new FormData($('#edit-producto')[0]);
    $.ajax({
        url: '/products/edit',
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
                text: 'No se pudo actualizar el producto. Inténtalo nuevamente.',
            });
        }
    });
}

// Enviar solicitud para eliminar un producto
function showRemoveProduct(productId) {
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
                url: '/products/remove',
                method: 'POST',
                data: { id: productId },
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
                        text: 'No se pudo eliminar el producto. Inténtalo nuevamente.',
                    });
                }
            });
        }
    });
}
