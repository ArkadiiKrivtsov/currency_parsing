<?php
/* запускаем сессию*/
session_start();
/*включаем вывод ошибок на экран */
error_reporting(E_ALL);
ini_set('display_errors', true);
/*создаем константы-путь до файла */
define('APP_DIR', dirname(__DIR__));
const PAGE_DIR = DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR;

require_once APP_DIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controllers\PagesController;
use App\Database\DatabaseConnection;
use App\Exceptions\PageNotFoundException;
use App\Repository\LastRunTimeRepository;
use App\Router;
use App\Services\CurrencyParserService;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

$dotenv = Dotenv::createImmutable(APP_DIR);
$dotenv->load();

// Создаем объект Request, который представляет HTTP-запрос
$request = Request::createFromGlobals();

$router = new Router();
$router->get('/', [PagesController::class, 'home']);
$router->get('/main', [PagesController::class, 'main']);
$router->post('/main', [PagesController::class, 'calculate']);
$router->get('/register', [PagesController::class, 'register']);
$router->post('/register', [PagesController::class, 'create']);
$router->post('/login', [PagesController::class, 'login']);
$router->get('/logout', [PagesController::class, 'logout']);

//проверяем подключение к бд
$databaseConnection = DatabaseConnection::getInstance();
$connection = $databaseConnection->getConnection();

// Вызываем метод run и передаем ему объект Request
try {
    $response = $router->run($request);
} catch (PageNotFoundException $e) {
    require_once APP_DIR . PAGE_DIR . 'errors' . DIRECTORY_SEPARATOR . '404.php';
}
// Отправляем ответ клиенту
if (isset($response)) {
    $response->send();
}

//обновление курса на каждые 3 часа
$lastRunTimeRepository = new LastRunTimeRepository();

if ($lastRunTimeRepository->isTimeToUpdate()) {
    $parserService = new CurrencyParserService();
    $parserService->update();
    $lastRunTimeRepository->updateTime();
}
