<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class PagesController extends Controller
{
    public function home(): Response
    {
        return $this->view('pages/login.php');
    }

    public function create(): Response
    {
        return $this->view('pages/create_user.php');
    }
}
