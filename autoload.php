<?php

spl_autoload_register(function ($className) {
    $namespace = str_replace('\\', '/', __NAMESPACE__);
    $className = str_replace('\\', '/', $className);
    $class = (empty($namespace) ? '' : $namespace . '/') . $className . '.php';
    include_once($class);
});

// this file will be made by composer
require_once('vendor/autoload.php');