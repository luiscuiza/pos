<form action="" method="post" id="reg-cliente">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        
        <!-- Nombre-->
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre de Contacto" required>
            </div>
        </div>

        <!-- Razón Social -->
        <div class="form-group">
            <label for="razon_social">Razón Social</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-building"></i>
                    </span>
                </div>
                <input class="form-control" type="text" id="razon_social" name="razon_social" placeholder="Razón Social" required>
            </div>
        </div>

        <!-- NIT / CI -->
        <div class="form-group">
            <label for="nit_ci">NIT / CI</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-id-card"></i>
                    </span>
                </div>
                <input class="form-control" type="text" id="nit_ci" name="nit_ci" placeholder="NIT / CI" required>
            </div>
        </div>

        <!-- Dirección -->
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                </div>
                <input class="form-control" type="text" id="direccion" name="direccion" placeholder="Dirección" required>
            </div>
        </div>

        

        <!-- Teléfono -->
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-phone"></i>
                    </span>
                </div>
                <input class="form-control" type="text" id="telefono" name="telefono" placeholder="Teléfono" required>
            </div>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                <input class="form-control" type="email" id="email" name="email" placeholder="Email" required>
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
            registerCustomer();
        }
    });

    $(function () {
        $('#reg-cliente').validate({
            rules: {
                razon_social: {
                    required: true,
                    minlength: 3
                },
                nit_ci: {
                    required: true,
                    minlength: 5
                },
                direccion: {
                    required: true,
                    minlength: 5
                },
                nombre: {
                    required: true,
                    minlength: 3
                },
                telefono: {
                    required: true,
                    minlength: 7
                },
                email: {
                    required: true,
                    email: true
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
