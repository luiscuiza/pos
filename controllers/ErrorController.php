<?php

class ErrorController {

    public static function render(int $code, string $message = null) {
        $title = "Error - $code";
        $data = [
            'title' => $title,
            'message' => $message
        ];
        switch ($code) {
            case 400:
                TemplateController::render('./views/errors/400.php', './views/layout/sidebar.php', $data);
                break;
            case 404:
                TemplateController::render('./views/errors/404.php', './views/layout/sidebar.php', $data);
                break;
            case 500:
                TemplateController::render('./views/errors/500.php', './views/layout/sidebar.php', $data);
                break;
            default:
                TemplateController::render('./views/errors/default.php', './views/layout/sidebar.php', $data);
                break;
        }
    }
}