<?php
/* запускаем сессию*/
//session_start();
/*включаем вывод ошибок на экран */
error_reporting(E_ALL);
ini_set('display_errors', true);
/*создаем константы-путь до файла */
define('APP_DIR', dirname(__DIR__));

require_once APP_DIR . '/vendor/autoload.php';

use App\Controllers\PagesController;
use App\Router;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

$dotenv = Dotenv::createImmutable(APP_DIR);
$dotenv->load();
/*подключаемся к БД */
//require_once APP_DIR . '/config/database.php';

const PAGE_DIR = '/public/templates/pages/';

// Создаем объект Request, который представляет HTTP-запрос
$request = Request::createFromGlobals();

$router = new Router();

$router->get('/', [PagesController::class, 'home']);
$router->get('/create', [PagesController::class, 'create']);

// Вызываем метод run и передаем ему объект Request
$response = $router->run($request);

// Отправляем ответ клиенту
$response->send();
