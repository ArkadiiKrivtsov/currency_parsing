<?php

namespace App\Controllers;

use App\Auth;
use App\Contracts\FlashMessagesContract;
use App\Exceptions\AuthException;
use App\Exceptions\RedirectException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
    const REDIRECT_URL = '/';

    public function __construct(
        private readonly FlashMessagesContract $flashMessages,
        private readonly Auth $auth, 
        private readonly Request $request,
        private readonly Session $session)
    {
    }

    public function login(): Response
    {
        $this->onlyNotAuth(self::REDIRECT_URL);
     
        $oldValues = $this->session->getFlashBag()->get('old', []);

        return $this->view('pages/login.php', ['fields' => $oldValues]);
    }

    public function authorize(): Response
    {
        $this->onlyNotAuth(self::REDIRECT_URL);
        
        $redirectUrl = self::REDIRECT_URL;

        $fields = $this->request->request;

        try {
            $user = $this->auth->attempt(
                $fields->get('email', ''),
                $fields->get('password', '')
            );

            $this->auth->login($user);
            $this->flashMessages->success(['Вы успешно авторизованы']);
        } catch (AuthException $exception) {
            $this->flashMessages->error(['Неверно указаны логин или пароль']);
            $this->session->getFlashBag()->set('old', $fields->all());
            $redirectUrl = '/login/';
        }

        return new RedirectResponse($redirectUrl);
    }

    public function logout(): Response
    {
        $this->onlyAuth(self::REDIRECT_URL);

        $this->auth->logout();
        $this->flashMessages->success(['Заходите к нам еще']);

        return new RedirectResponse(self::REDIRECT_URL);
    }
}
