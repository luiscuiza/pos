<?php ob_start(); ?>
    <style>
        body {
            background-color: black !important;
        }
        .card {
            width: 400px;
            border: none;
            padding: 20px;
            overflow: hidden;
            text-align: center;
            border-radius: 10px;
            background-color: #08213D;
        }
        .text-message {
            color: #D1D1D1;
            margin-top: 16px;
            margin-bottom: px;
        }
    </style>
<?php $headCss = ob_get_clean(); ?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card">
        <img src="/assets/dist/img/404.png" alt="404 Error" class="img-fluid">
        <p class="text-message"><?php echo $message ?? 'Lo sentimos, la página que buscas no existe.'; ?></p>
        <a href="/" class="btn btn-primary">Volver a la página principal</a>
    </div>
</div>
