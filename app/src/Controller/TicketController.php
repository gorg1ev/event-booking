<?php

namespace App\Controller;

use App\Exception\EventNotFoundException;
use App\Service\TicketService;
use App\Session;
use App\View;

class TicketController
{
    private TicketService $ticketService;
    private Session $session;

    public function __construct()
    {
        $this->ticketService = new TicketService();
        $this->session = new Session();
    }

    public function tickets()
    {
        if (!$this->session->isLoggedIn()) {
            header('Location: /');
            exit;
        }


        try {
            $tickets = $this->ticketService->getTickets($this->session->get('user', 'id'));
        } catch (\PDOException $e) {
            $this->session->set('error', 'There was a problem fetching you tickets!');
            exit;
        } finally {
            return View::make('tickets', ['tickets' => $tickets ?? []]);
        }
    }

    public function createTicket()
    {
        if (!$this->session->isLoggedIn()) {
            http_response_code(409);
            header("Content-Type: application/json");
            echo json_encode([
                'message' => 'You need to be logged in to bought ticket!'
            ]);
            exit;
        }

        $eventId = $_POST['id'];
        $user_id = $this->session->get('user', 'id');
        $amount = $_POST['amount'];
        try {
            $this->ticketService->createTicker($eventId, $user_id, $amount);
            $this->session->set('success', 'You bought ' . $amount . ' ticket/s successfully.');
            header('Location: /event?id=' . $eventId);
        } catch (\PDOException|\InvalidArgumentException $e) {
            $this->session->set('error', $e->getMessage());
            header('Location: /event?id=' . $eventId);
        } catch (EventNotFoundException $e) {
            $this->session->set('error', $e->getMessage());
            header('Location: /');
        }
    }
}