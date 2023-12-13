<?php

namespace App\Controllers;

use App\Contracts\CarsRepositoryContract;
use App\Repositories\CarsRepository;
use Symfony\Component\HttpFoundation\Response;

class PagesController extends Controller
{
    private CarsRepository $carRepository;

    public function __construct()
    {
        $this->carRepository = container()->get(CarsRepositoryContract::class);
    }


    public function home(): Response
    {
        $cars = $this->carRepository->getSalesCars();

        return $this->view('pages/home.php', ['cars' => $cars]);
    }

}
