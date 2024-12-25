<?php

namespace App\Controller;

use App\Enum\UserRole;
use App\Exception\EventNotFoundException;
use App\Exception\InvalidFileTypeException;
use App\Service\EventService;
use App\Session;
use App\View;
use InvalidArgumentException;

class EventController
{
    private EventService $eventService;
    private Session $session;

    public function __construct()
    {
        $this->eventService = new EventService();
        $this->session = new Session();
    }

    public function showAddEventForm(): View
    {
        if (!$this->session->isAdmin()) {
            header('Location: /');
        }

        return View::make('eventForm');
    }

    public function createEvent()
    {
        if (!$this->session->isAdmin()) {
            http_response_code(409);
            header("Content-Type: application/json");
            echo json_encode([
                'message' => 'Only admin can access this page!'
            ]);
            exit;
        }

        try {
            $this->eventService->createEvent(
                $_FILES['thumbnail'],
                $_POST['title'],
                $_POST['description'],
                $_POST['location'],
                floatval($_POST['price']),
                $_POST['date']
            );
        } catch (InvalidArgumentException|InvalidFileTypeException $e) {
            $this->session->set('error', $e->getMessage());
            header('Location: /add-event');
        }
    }

    public function showEvent(): View
    {
        if (!isset($_GET['id'])) {
            $this->session->set('error', 'Id is not found');
            header('Location: /');
        }

        $id = $_GET['id'];
        if ($id == 0 || empty($id)) {
            $this->session->set('error', 'Id cant be empty');
            header('Location: /event?id=' . $id);
        }

        try {
            $event = $this->eventService->getEvent($id);
        } catch (EventNotFoundException $e) {
            $this->session->set('error', $e->getMessage());
            header('Location: /event?id=' . $id);
        } finally {
            return View::make('event', ['event' => $event ?? []]);
        }
    }
}