<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Controllers\PagesController;
use MVC\Router;

$router = new Router();

// Home
$router->get('/', [PagesController::class, 'index']);
$router->get('/circuit', [PagesController::class, 'circuit']);
$router->get('/graphs', [PagesController::class, 'graphs']);

// Login
$router->get('/login', [PagesController::class, 'login']);
$router->post('/login', [PagesController::class, 'login']);
$router->get('/logout', [PagesController::class, 'logout']);

// API's
$router->post('/api/save', [APIController::class, 'save_data']);
$router->post('/api/update-brightness', [APIController::class, 'update_brightness']);
$router->get('/api/leds', [APIController::class, 'update_leds']);
$router->get('/api/data', [APIController::class, 'get_data']);


$router->comprobarRutas();