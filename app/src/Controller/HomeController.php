<?php

namespace App\Controller;

use App\Service\EventService;
use App\View;

class HomeController
{
    private EventService $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }

    public function index()
    {
        return View::make('index', ['events' => $this->eventService->getEvents()]);
    }
}