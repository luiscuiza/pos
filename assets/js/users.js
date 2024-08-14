
function showNewUser() {
    $("#modal-default").modal("show");
    var obj="";
    $.ajax({
        type:"GET",
        url:"/users/new",
        data: obj,
        success: function(data) {
            $("#content-default").html(data);
        }
    });
}

function showEditUser(id) {
    $("#modal-default").modal("show");
    $.ajax({
        type: "GET",
        url: "/users/edit",
        data: { id: id },
        success: function(data) {
            $("#content-default").html(data);
        }
    });
}

function showRemoveUser(id) {
    Swal.fire({
        title: 'Eliminar Usuario',
        text: "Esta acción eliminará al usuario de forma permanente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar',
        dangerMode: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "/users/remove",
                data: { id: id },
                success: function(data) {
                    console.log(data);
                    try {
                        var response = JSON.parse(data);
                        if (response.status === "OK") {
                            Swal.fire({
                                title: 'Usuario eliminado',
                                text: 'El usuario ha sido eliminado exitosamente.',
                                icon: 'success',
                                timer: 2500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                                //window.location.href = "/";
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message || 'No se pudo eliminar al usuario.',
                                icon: 'error',
                                timer: 2500,
                                showConfirmButton: false
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: 'Error de respuesta',
                            text: 'No se pudo procesar la respuesta del servidor.',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2500
                        });
                        console.error("Error al procesar JSON: ", e);
                    }
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'Cancelado',
                text: 'La eliminación del usuario ha sido cancelada.',
                icon: 'info',
                timer: 2500,
                showConfirmButton: false
            });
        }
    });
}

function registerUser() {
    var formData = new FormData($("#reg-usuario")[0]);
    if (formData.get("password") === formData.get("vrpassword")) {
        $.ajax({
            type: "POST",
            url: "/users/add",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                try {
                    var response = JSON.parse(data);
                    if (response.status === "OK") {
                        Swal.fire({
                            title: 'El usuario ha sido registrado',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Ha ocurrido un error',
                            text: response.message,
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        title: 'Error de respuesta',
                        text: 'No se pudo procesar la respuesta del servidor.',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2500
                    });
                    console.error("Error al procesar JSON: ", e);
                }
            }
        });
    } else {
        Swal.fire({
            title: 'Las contraseñas no coinciden',
            icon: 'warning',
            showConfirmButton: true
        });
    }
}

function editUser() {
    console.log("USER EDIT CALLED");
    var formData = new FormData($("#edit-usuario")[0]);
    if (formData.get("password") !== formData.get("vrpassword")) {
        Swal.fire({
            title: 'Las contraseñas no coinciden',
            icon: 'warning',
            showConfirmButton: true
        });
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/users/edit',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            try {
                var response = JSON.parse(data);
                if (response.status === 'OK') {
                    Swal.fire({
                        title: 'Usuario actualizado exitosamente',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Ha ocurrido un error',
                        text: response.message,
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            } catch (e) {
                Swal.fire({
                    title: 'Error de respuesta',
                    text: 'No se pudo procesar la respuesta del servidor.',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2500
                });
                console.error("Error al procesar JSON: ", e);
            }
        }
    });
}
