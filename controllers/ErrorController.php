<?php

class ErrorController {

    public static function render(int $code, string $message = null) {
        $title = "Error - $code";
        $data = [
            'title' => $title,
            'message' => $message
        ];
        switch ($code) {
            case 404:
                TemplateController::render('./views/errors/404.php', null, $data);
                break;
            case 500:
                TemplateController::render('./views/errors/500.php', null, $data);
                break;
            default:
                TemplateController::render('./views/errors/default.php', null, $data);
                break;
        }
    }
}