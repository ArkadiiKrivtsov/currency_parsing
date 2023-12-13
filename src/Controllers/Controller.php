<?php

namespace App\Controllers;

use App\Exceptions\RedirectException;
use App\View;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    protected function view(string $template, array $data = []): Response
    {
        $view = new View($template);
        return new Response($view->render($data));
    }

    protected function onlyAuth(string $url): void
    {
        if (! auth()->isAuthorized()) {
            throw new RedirectException($url);
        }
    }

    protected function onlyNotAuth(string $url): void
    {
        if (auth()->isAuthorized()) {
            throw new RedirectException($url);
        }
    }
}
