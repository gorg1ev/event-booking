<?php

use App\App;
use App\Config;
use App\Controller\AuthController;
use App\Controller\EventController;
use App\Controller\HomeController;
use App\Controller\TicketController;
use App\Router;
use Dotenv\Dotenv;


require __DIR__ . '/../vendor/autoload.php';

session_start();

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const PUBLIC_DIR = __DIR__;
const VIEW_PATH = __DIR__ . '/../src/View';

$router = new Router();

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/login', [AuthController::class, 'showLoginForm'])
    ->post('/login', [AuthController::class, 'login'])
    ->get('/register', [AuthController::class, 'showRegisterFrom'])
    ->post('/register', [AuthController::class, 'register'])
    ->get('/logout', [AuthController::class, 'logout'])
    ->get('/my-profile', [AuthController::class, 'showProfileForm'])
    ->post('/my-profile', [AuthController::class, 'profile'])
    ->get('/add-event', [EventController::class, 'showAddEventForm'])
    ->post('/create-event', [EventController::class, 'createEvent'])
    ->get('/event', [EventController::class, 'showEvent'])
    ->get('/tickets', [TicketController::class, 'tickets'])
    ->post('/ticket', [TicketController::class, 'createTicket']);


$app = new App($router, [
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
);

$app->run();



