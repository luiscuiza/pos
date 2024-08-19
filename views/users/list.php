<?php 
    $tableID = 'users';
?>
<!-- HEAD CSS -->
<?php ob_start(); ?>
    <?php include 'views/layout/ListCss.php'; ?>
<?php $headCss = ob_get_clean(); ?>

<!-- BODY JS -->
<?php ob_start(); ?>
    <?php include 'views/layout/ListJs.php'; ?>
    <script src="/assets/js/users.js"></script>
    <?php include 'views/layout/TableConfig.php'; ?>
<?php $bodyJs = ob_get_clean(); ?>

<section class="content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Usuarios</h1>
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="showNewUser()">
                                <i class="fas fa-user-plus"></i> Nuevo Usuario </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="<?php echo $tableID ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Perfil</th>
                                    <th>Estado</th>
                                    <th>Último Acceso</th>
                                    <th>Fecha de registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr class="odd">
                                            <td><?= htmlspecialchars($user['login_usuario']) ?></td>
                                            <td><?= htmlspecialchars($user['perfil']) ?></td>
                                            <td>
                                                <?php if ($user['estado_usuario']): ?>
                                                    <span class="badge badge-success">Activo</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Inactivo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($user['ultimo_login']) ?></td>
                                            <td><?= htmlspecialchars($user['fecha_registro']) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn edit btn-dark rounded-left" style="padding-right: 8px;" onclick="showEditUser(<?= htmlspecialchars($user['id_usuario']) ?>)"><i class="fas fa-edit"></i></a>
                                                    <a class="btn remove btn-dark rounded-right" onclick="showRemoveUser(<?= htmlspecialchars($user['id_usuario']) ?>)"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
