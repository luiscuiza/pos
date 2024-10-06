<?php ob_start(); ?>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/plugins/bs-stepper/css/bs-stepper.min.css">
    <link rel="stylesheet" href="/assets/plugins/dropzone/min/dropzone.min.css">
<?php $headCss = ob_get_clean(); ?>

<?php ob_start(); ?>
    <script src="/assets/plugins/chart.js/Chart.min.js"></script>
    <script src="/assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="/assets/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/assets/js/dashboard.js"></script>
<?php $bodyJs = ob_get_clean(); ?>

<section class="content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fw-bold mt-2">Panel de Administración</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Usuarios -->
                            <div class="col-xl col-6">
                                <div class="small-box bg-dark">
                                <div class="inner">
                                    <h3><?= $users ?></sup></h3>
                                    <p>Usuarios</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person" style="color: #AAA;"></i>
                                </div>
                                <a href="/users" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- Clientes -->
                            <div class="col-xl col-6">
                                <div class="small-box bg-dark">
                                <div class="inner">
                                    <h3><?= $customers ?></h3>
                                    <p>Clientes</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios-people" style="color: #AAA;"></i>
                                </div>
                                <a href="/customers" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- Productos -->
                            <div class="col-xl col-6">
                                <div class="small-box bg-dark">
                                <div class="inner">
                                    <h3><?= $productos ?></h3>
                                    <p>Productos</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios-cart" style="color: #AAA;"></i>
                                </div>
                                <a href="/products" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- Ventas -->
                            <div class="col-xl col-6">
                                <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $facturas ?></h3>
                                    <p>Ventas</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="/sales" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- Ventas -->
                            <div class="col-xl col-6">
                                <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $anulados ?></h3>
                                    <p>Ventas Anuladas</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="/sales" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group m-2">
                                <div class="input-group">
                                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                        <i class="far fa-calendar-alt"></i> Fecha <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card bg-gradient-dark m-2" style="width: 100%;">
                                <div class="card-header border-0 ui-sortable-handle d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shopping-cart mr-1"></i>
                                        <h3 class="card-title">Ventas</h3>
                                    </div>
                                    <h3 class="card-title text-center flex-grow-1" id="reportrange"><span></span></h3>
                                    <div class="ml-3">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>
                                <div class="card-body" style="display: block;">
                                    <canvas class="chart chartjs-render-monitor" id="line-chart" style="height:250px; width: 100%; display: block;" width="100%" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
