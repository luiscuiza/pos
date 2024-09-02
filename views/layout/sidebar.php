<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <div class="nav-link">
                    <span class="badge badge-danger" id="sin-status">SIN - Desconectado</span>
                </div>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <div class="nav-link">
                    <span class="badge badge-danger" id="cufd-status">CUFD - Caducado</span>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/logout" role="button">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="/assets/dist/img/Logo_POS.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" >
            <span class="brand-text font-weight-light" style="font-size: 25px;">Sistema POS</span>
        </a>
        <div class="sidebar">
            <div class="user-panel d-flex">
                <div class="image">
                    <?php if (!empty($_SESSION['photo'])): ?>
                        <img src="/uploads/users/<?= $_SESSION['photo'] ?>" class="img-circle elevation-2" alt="User Image" style="width: 45px; height: 45px; margin: 5px 0 5px 0;">
                    <?php else: ?>
                        <i class="fas fa-user-circle" style="color: #c2c7d0; font-size: 45px; margin: 5px 0 5px 0;"></i>
                    <?php endif; ?>
                </div>
                <div class="info">
                    <input type="hidden" name="usuarioLoggin" value="<?= $_SESSION['user'] ?>">
                    <a href="#" class="d-block" style="font-size: 18px;"><?= ucwords(strtolower($_SESSION['user'])) ?></a>
                    <span style="color: #AAAAAA; font-size: 16px;"><?= ucwords(strtolower($_SESSION['perfil'])) ?></span>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Usuarios<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/users" class="nav-link">
                                    <i class="fas fa-list" style="margin-right: 4px;"></i>
                                    <span>Lista de usuarios</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Clientes<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/customers" class="nav-link">
                                    <i class="fas fa-list" style="margin-right: 4px;"></i>
                                    <span>Lista de clientes</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Productos<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/products" class="nav-link">
                                    <i class="fas fa-list" style="margin-right: 4px;"></i>
                                    <span>Lista de productos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/products/catalog" class="nav-link">
                                    <i class="fas fa-list" style="margin-right: 4px;"></i>
                                    <span>Sincronizacion catalogos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/products/umedsin" class="nav-link">
                                    <i class="fas fa-list" style="margin-right: 4px;"></i>
                                    <span>Unidad de Medidas</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Ventas<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/sales/emit" class="nav-link">
                                    <i class="fas fa-file-invoice" style="margin-right: 4px;"></i>
                                    <span>Emitir Factura</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper">
        <?php echo $content ?? ''; ?>
    </div>
    <footer class="main-footer"></footer>
</div>
<style>
    #sin-status, #cufd-status {
        font-size: 12px !important;
    }
</style>