<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title ?? 'POS'; ?></title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
        <link rel="icon" href="/assets/dist/img/Logo_POS.png">
        <?php echo $headCss ?? ''; ?>
        <?php echo $headJs ?? ''; ?>
    </head>
    <body> 
        <?php
            if (!empty($sidebar)) {
                include $sidebar;
            } else {
                echo $content ?? '';
            }
        ?>
        <?php echo $bodyCss ?? ''; ?>
        <script src="/assets/plugins/jquery/jquery.min.js"></script>
        <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/dist/js/adminlte.min.js"></script>
        <?php echo $bodyJs ?? ''; ?>
    </body>
</html>
