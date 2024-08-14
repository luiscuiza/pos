<?php

class DashboardController {

    static public function render() {
        TemplateController::render('./views/dashboard.php', './views/layout/sidebar.php');
    }
    
}