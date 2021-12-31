<?php

use system\core\Router;
use App\Controller\HomeController;

Router::get('/', [HomeController::class, 'index']);
Router::post('/create', [HomeController::class, 'store']);
Router::get('/edit', [HomeController::class, 'edit']);
Router::post('/update', [HomeController::class, 'update']);
Router::post('/delete', [HomeController::class, 'delete']);
Router::get('/show', [HomeController::class, 'show']);