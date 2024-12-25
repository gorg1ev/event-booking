<?php

namespace App\Model;

use App\Model;

class TicketModel extends Model
{
    public function createTicket(int $eventId, int $userId, int $amount)
    {
        $stmt = $this->db->prepare("INSERT INTO ticket (event_id ,user_id, amount)
                            VALUES (:eventId, :userId, :amount)");
        try {

            $stmt->execute([
                ':eventId' => $eventId,
                ':userId' => $userId,
                ':amount' => $amount,
            ]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    public function getTickets($id)
    {
        $stmt = $this->db->prepare("SELECT t.id AS id, e.id AS event_id, e.title, e.price, t.amount, t.date_bought
                                    FROM ticket t
                                    JOIN events e ON e.id = t.event_id
                                    WHERE t.user_id = :id;");
        try {
            $stmt->execute([
                ':id' => $id
            ]);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }
}