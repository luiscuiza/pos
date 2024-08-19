
function showForm(path, action, id = null) {
    let url = `/${path}/${action}`;
    let data = id ? { id: id } : {};
    $.ajax({
        url: url,
        method: 'GET',
        data: data,
        success: function(response) {
            $( `#${path}-${action}-dialog`).remove();
            $('body').append(response);
            $( `#${path}-${action}-dialog`).modal('show');
            $( `#${path}-${action}-dialog`).modal('show').on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire({
				timer: 2500,
                icon: 'error',
                title: 'Error',
                text: `No se pudo cargar el formulario. Inténtalo nuevamente.`,
            });
        }
    });
}

function saveRecord(path, action, formId) {
    var formData = new FormData($(`#${formId}`)[0]);
    $.ajax({
        url: `/${path}/${action}`,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'OK') {
                Swal.fire({
					timer: 2500,
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message,
                }).then(function() {
                    location.reload();
                });
            } else {
                Swal.fire({
                    timer: 2500,
					icon: 'error',
                    title: 'Error',
                    text: result.message,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                timer: 2500,
				icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar los datos. Inténtalo nuevamente.',
            });
        }
    });
}

function deleteRecord(path, id) {
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
                url: `/${path}/remove`,
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'OK') {
                        Swal.fire({
							timer: 2500,
                            icon: 'success',
                            title: 'Eliminado',
                            text: result.message,
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
							timer: 2500,
                            icon: 'error',
                            title: 'Error',
                            text: result.message,
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        timer: 2500,
						icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el contenido. Inténtalo nuevamente.',
                    });
                }
            });
        }
    });
}
