<?php

class Environment
{
    private $vars = [];

    public function __construct($filePath = '.env')
    {
        $this->load($filePath);
    }

    private function load($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("El archivo $filePath no existe.");
        }
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            $this->vars[$key] = $value;
        }
    }

    public function get($key, $default = null)
    {
        return $this->vars[$key] ?? $default;
    }

}