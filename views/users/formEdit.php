<?php
    $userId = $user['id_usuario'];
    $login_usuario = $user['login_usuario'];
    $perfil = $user['perfil'];
    $estado = $user['estado_usuario'];
?>

<form id="edit-usuario">
    <input type="hidden" name="id" value="<?php echo $userId; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
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
                <input class="form-control" type="text" id="login_usuario" name="login_usuario" placeholder="Usuario" value="<?php echo htmlspecialchars($login_usuario); ?>" required>
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
                    <option value="Usuario" <?php echo ($perfil === 'Usuario') ? 'selected' : ''; ?>>Usuario</option>
                    <option value="Administrador" <?php echo ($perfil === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>
        </div>
        <!-- estado -->
        <div class="form-group">
            <label for="estadoUsuario">Estado del Usuario</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-toggle-on"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center switch-container">
                    <label class="switch my-1 px-1">
                        <input type="checkbox" id="estadoUsuario" name="estado_usuario" value="1" <?php echo $estado ? 'checked' : ''; ?> onchange="toggleStatusSwitch(this)">
                        <span class="slider"></span>
                    </label>
                    <span class="status-label <?php echo $estado ? 'label-status-active' : 'label-status-inactive'; ?>">
                        <?php echo $estado ? 'Activo' : 'Inactivo'; ?>
                    </span>
                </div>
            </div>
        </div>
        <!-- password -->
        <div class="form-group">
            <label for="password">Nueva Contraseña (dejar en blanco para no cambiar)</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                <input class="form-control" type="password" id="password" name="password" placeholder="Nueva Contraseña">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                <input class="form-control" type="password" id="vrpassword" name="vrpassword" placeholder="Repetir Contraseña">
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
            editUser();
        }
    });

    $(function () {
        $('#edit-usuario').validate({
            rules: {
                login_usuario: {
                    required: true,
                    minlength: 5
                },
                password: {
                    minlength: 5
                },
                vrpassword: {
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
