<?php

class TemplateController {

    public static function render(string $viewContent, string $viewSidebar = null, array $data = []) {
        extract($data);
        
        ob_start();
        if (file_exists($viewContent)) {
            include $viewContent;
        }
        $content = ob_get_clean();
        
        $sidebar = null;
        if (!empty($viewSidebar) && file_exists($viewSidebar)) {
            $sidebar = $viewSidebar;
        }
        include './views/layout/template.php';
    }
}