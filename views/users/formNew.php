<form action="" method="post" id="reg-usuario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <!-- usuario -->
        <div class="form-group">
            <label for="login_usuario">Usuario</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-user-tie"></i>
                    </span>
                </div>
                <input class="form-control" type="text" id="login_usuario" name="login_usuario" placeholder="Usuario" required>
            </div>
        </div>
        <!-- perfil -->
        <div class="form-group">
            <label for="perfil">Perfil</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-user-tag"></i>
                    </span>
                </div>
                <select class="form-control" name="perfil" id="perfil">
                    <option value="Usuario" selected>Usuario</option>
                    <option value="Administrador">Administrador</option>
                </select>
            </div>
        </div>
        <!-- password -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña" required>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                <input class="form-control" type="password" id="vrpassword" name="vrpassword" placeholder="Repetir Contraseña" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" style="width: 100px;" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" style="width: 100px;">Guardar</button>
    </div>
</form>

<script>
    $.validator.setDefaults({
        submitHandler: function () {
            registerUser();
        }
    });

    $(function () {
        $('#reg-usuario').validate({
            rules: {
                login_usuario: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 5
                },
                vrpassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                perfil: {
                    required: true
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
