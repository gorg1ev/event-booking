<?php

namespace App\Model;

use App\DB;
use App\Model;

class EventModel extends Model
{
    public function createEvent(string $title, string $description, string $location, float $price, string $date): int
    {
        $stmt = $this->db->prepare("INSERT INTO events (title, description, location, price, expired_date)
                            VALUES (:title, :description, :location, :price, :date)");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':location' => $location,
            ':price' => $price,
            ':date' => $date
        ]);

        return $this->db->lastInsertId();
    }

    public function setThumbnail(int $id, string $thumbnailPath)
    {
        $stmt = $this->db->prepare("UPDATE events SET thumbnail = :thumbnail
                                    WHERE id = :id");
        $stmt->execute([
            ':thumbnail' => $thumbnailPath,
            ':id' => $id
        ]);
    }

    public function getEvents()
    {
        $stmt = $this->db->prepare("SELECT * FROM events");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getEvent(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
        ]);

        return $stmt->fetch();
    }
}