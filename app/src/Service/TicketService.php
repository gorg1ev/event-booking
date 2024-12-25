<?php

namespace App\Service;

use App\Exception\EventNotFoundException;
use App\Model\EventModel;
use App\Model\TicketModel;
use InvalidArgumentException;

class TicketService
{

    private TicketModel $ticketModel;
    private EventModel $eventModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->eventModel = new EventModel();
    }

    public function getTickets(int $id)
    {
        return $this->ticketModel->getTickets($id);
    }

    public function createTicker(int $eventId, int $userId, int $amount)
    {
        if (!$amount > 0) {
            throw new InvalidArgumentException('Invalid amount');
        }

        if (empty($this->eventModel->getEvent($eventId))) {
            throw new EventNotFoundException();
        }

        try {
            $this->ticketModel->createTicket($eventId, $userId, $amount);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }
}