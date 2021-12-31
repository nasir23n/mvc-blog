<?php

spl_autoload_register(function($url) {
    $path = $url.'.php';
    if (file_exists($path)) {
        include_once $path;
    }
});