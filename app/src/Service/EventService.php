<?php

namespace App\Service;

use App\Exception\EventNotFoundException;
use App\Exception\InvalidFileTypeException;
use App\Model\EventModel;
use InvalidArgumentException;

class EventService
{
    private AvatarService $avatarService;
    private EventModel $eventModel;

    public function __construct()
    {
        $this->avatarService = new AvatarService();
        $this->eventModel = new EventModel();
    }

    public function createEvent(array $thumbnail, string $title, string $description, string $location, float $price, string $date)
    {
        if (empty($thumbnail['name']) || empty($title) || empty($description) || empty($location) || empty($price) || empty($date)) {
            throw new InvalidArgumentException("All fields are required!");
        }

        $this->avatarService->setExtendion($thumbnail['name']);

        if ($this->avatarService->isValidExtendion($this->avatarService->getExtendion())) {
            throw new InvalidFileTypeException('Only .jpg and .png files are allowed for avatar.');
        }

        $id = $this->eventModel->createEvent($title, $description, $location, $price, $date);

        $this->avatarService->setLocation('storage/events', $title, $id, $this->avatarService->getExtendion());

        $this->eventModel->setThumbnail($id, $this->avatarService->getLocation());

        move_uploaded_file($thumbnail['tmp_name'], PUBLIC_DIR . $this->avatarService->getLocation());

        header('Location: /');
    }

    public function getEvents()
    {
        return $this->eventModel->getEvents();
    }

    public function getEvent(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cant be empty');
        }

        try {
            return $this->eventModel->getEvent($id);
        } catch (\PDOException $e) {
            throw new EventNotFoundException();
        }
    }

}