<?php

namespace App\Controllers;

use App\Auth;
use App\Repository\CurrenciesRepository;
use App\Repository\UsersRepository;
use App\Services\ConverterService;
use App\Services\CurrencyParserService;
use App\Services\ValidateService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PagesController extends Controller
{
    private Auth $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function home(): Response
    {
        return $this->view('pages/login.php');
    }

    public function register(): Response
    {
        return $this->view('pages/register.php');
    }

    public function create(Request $request): Response
    {
        $data = $request->request->all();

        $validateService = new ValidateService($data);
        $usersRepository = new UsersRepository();

        if ($validateService->validate() && $usersRepository->create($data)) {
            return $this->view('pages/login.php', ['success_message' => 'Вы успешно зарегистрированы. Войдите в сервис']);
        }

        return $this->view('pages/register.php');
    }

    public function login(Request $request): Response
    {
        $data = $request->request->all();

        if (! $this->auth->login($data)) {
            return $this->view('pages/login.php');
        }

        header('Location: /main');
        exit();
    }

    public function logout(): Response
    {
        $this->auth->logout();

        return $this->view('pages/login.php', ['success_message' => 'До скорых встреч!']);
    }
    public function main()
    {
        if (isset($_SESSION['isUserVerifyed']) && $_SESSION['isUserVerifyed']) {
            return $this->view('pages/main.php');
        }

        return $this->view('pages/login.php');
    }

    public function calculate(Request $request): Response
    {
        $data = $request->request->all();

        $converterService = new ConverterService();
        $total = $converterService->convert($data);

        return $this->view('pages/main.php', ['total' => $total]);
    }
}
