<?php ob_start(); ?>
    <style>
        body {
            background-color: #E9ECEF !important;
        }
    </style>
<?php $headCss = ob_get_clean(); ?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-box w-100" style="max-width: 400px;">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="/assets/dist/img/logo_login.png" alt="Logo" style="width: 200px;">
            </div>
            <div class="card-body">
                <form action="/login" method="POST">
                    <div class="input-group mb-3">
                        <label for="login_usuario" class="sr-only">Usuario</label>
                        <input type="text" class="form-control" placeholder="Usuario" name="login_usuario" id="login_usuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="password" class="sr-only">Contraseña</label>
                        <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-end">
                            <button type="submit" class="btn btn-primary btn-block">Acceder</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
