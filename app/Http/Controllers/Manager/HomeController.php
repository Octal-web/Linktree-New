<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\Manager\HomeService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    protected $service;

    public function __construct(HomeService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function index(): Response
    {
        $response = $this->service->carregarDados();

        return Inertia::render('Manager/Home/index', [
            'links' => $response['links'],
            'destaques' => $response['destaques'],
        ]);
    }
}
