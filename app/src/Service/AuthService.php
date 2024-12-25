<?php

namespace App\Service;

use App\Enum\UserRole;
use App\Exception\EmailAlreadyTakenException;
use App\Exception\InvalidFileTypeException;
use App\Model\UserModel;
use App\Session;
use InvalidArgumentException;

class AuthService
{
    private UserModel $userModel;
    private Session $session;
    private AvatarService $avatarService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = new Session();
        $this->avatarService = new AvatarService();
    }

    public function login(string $email, string $password)
    {
        if (empty($email) || empty($password)) {
            throw new InvalidArgumentException("All fields are required.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address.");
        }

        $user = $this->userModel->findUserByEmail($email);

        if (!$user || !password_verify($password, $user['pwd'])) {
            throw new InvalidArgumentException("Email or password are incorrect");
        }

        $roles = $this->userModel->getUserRoles($user['id']);

        foreach ($roles as $role) {
            $user['roles'][] = UserRole::tryFrom($role)->name;
        }

        unset($user['pwd']);
        $this->session->set('user', $user);
    }


    public function registerUser(string $fullName, string $email, string $password, string $confirmPassword)
    {
        if (empty($fullName) || empty($email) || empty($password)) {
            throw new InvalidArgumentException("All fields are required.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address.");
        }

        if ($password !== $confirmPassword) {
            throw new InvalidArgumentException("Passwords do not match.");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            $this->userModel->registerUser($fullName, $email, $hashedPassword);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new EmailAlreadyTakenException();
            }
        }
    }

    public function updateUser(string $fullName, string $password, string $confirmPassword, array $avatar)
    {
        if ($password !== $confirmPassword) {
            throw new InvalidArgumentException("Passwords do not match.");
        }

        if (empty($fullName) && empty($avatar['name'])) {
            throw new InvalidArgumentException("No data provided for update.");
        }

        // if fullName input is empty but user want to change the avatar, then take the current name
        // for later to name that avatar.
        if (empty($fullName)) {
            $fullName = $this->session->get('user', 'full_name');
        }

        if ($avatar['name']) {
            $currentAvatar = $this->session->get('user', 'avatar');
            $this->avatarService->setExtendion($avatar['name']);

            if ($this->avatarService->isValidExtendion($this->avatarService->getExtendion())) {
                throw new InvalidFileTypeException('Only .jpg and .png files are allowed for avatar.');
            }

            $this->avatarService->setLocation('storage', $fullName, $this->session->get('user', 'id'), $this->avatarService->getExtendion());

            // /storage/user-avatar.jpg is DEFAULT avatar
            if ($currentAvatar !== '/storage/user-avatar.jpg') {
                if (file_exists(PUBLIC_DIR . $currentAvatar)) {
                    unlink(PUBLIC_DIR . $currentAvatar);
                }
            }

            move_uploaded_file($avatar['tmp_name'], PUBLIC_DIR . $this->avatarService->getLocation());

            // Change in session if avatar is changed
            $this->session->replace('user', 'avatar', $this->avatarService->getLocation());
        }

        // If we change the full name we need to change the avatar name too,
        // because when we change avatar later on we will have the old avatar in storage un used.
        if ($fullName !== $this->session->get('user', 'full_name')) {
            $currentAvatar = PUBLIC_DIR . $this->session->get('user', 'avatar');
            if (file_exists($currentAvatar)) {
                $this->avatarService->setExtendion($currentAvatar);
                $this->avatarService->setLocation('storage', $fullName, $this->session->get('user', 'id'), $this->avatarService->getExtendion());
                rename($currentAvatar, PUBLIC_DIR . $this->avatarService->getLocation());
            }

            // Change in session if current name and submitted name are different
            $this->session->replace('user', 'full_name', $fullName);
            $this->session->replace('user', 'avatar', $this->avatarService->getLocation());
        }

        // Update db
        $this->userModel->updateUser($fullName, $password, $this->avatarService->getLocation());
    }
}