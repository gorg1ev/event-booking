<?php

namespace App\Controller;

use App\Exception\EmailAlreadyTakenException;
use App\Exception\InvalidFileTypeException;
use App\Service\AuthService;
use App\Session;
use App\View;
use InvalidArgumentException;

class AuthController
{

    private AuthService $authService;
    private Session $session;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->session = new Session();
    }

    private function isUserLoggedIn(): void
    {
        if ($this->session->isLoggedIn()) {
            header("Location: /");
            exit;
        }
    }

    public function showLoginForm(): View
    {
        $this->isUserLoggedIn();

        return View::make('login');
    }

    public function login()
    {
        if ($this->session->isLoggedIn()) {
            http_response_code(409);
            header("Content-Type: application/json");
            echo json_encode([
                'message' => 'You are already logged in!'
            ]);
            exit;
        }

        try {
            $this->authService->login($_POST['email'], $_POST['password']);
            header("Location: /");
        } catch (InvalidArgumentException $e) {
            $this->session->set('login_error', $e->getMessage());
            $this->session->set('login_email', $_POST['email']);
            header("Location: /login");
        }
    }

    public function showRegisterFrom(): View
    {
        $this->isUserLoggedIn();

        return View::make('register');
    }

    public function register()
    {
        if ($this->session->isLoggedIn()) {
            http_response_code(409);
            header("Content-Type: application/json");
            echo json_encode([
                'message' => 'To register a user u need to logout!'
            ]);
            exit;
        }

        try {
            $this->authService->registerUser($_POST['fullName'], $_POST['email'], $_POST['password'], $_POST['confirmPassword']);
            header('Location: /login');
        } catch (InvalidArgumentException $e) {
            $this->session->set('register_error', $e->getMessage());
            $this->session->set('register_fullName', $_POST['fullName']);
            $this->session->set('register_email', $_POST['email']);
            header('Location: /register');
        } catch (EmailAlreadyTakenException $e) {
            $this->session->set('register_error', $e->getMessage());
            $this->session->set('register_fullName', $_POST['fullName']);
            $this->session->delete('register_email');
            header('Location: /register');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        header("Location: /login");
    }

    public function showProfileForm(): View
    {
        if (!$this->session->isLoggedIn()) {
            header("Location: /");
            exit;
        }

        return View::make('profile');
    }

    public function profile()
    {
        if (!$this->session->isLoggedIn()) {
            http_response_code(409);
            header("Content-Type: application/json");
            echo json_encode([
                'message' => 'You need to be logged in!'
            ]);
            exit;
        }

        try {
            $this->authService->updateUser($_POST['fullName'], $_POST['password'], $_POST['confirmPassword'], $_FILES['avatar']);
            header('Location: /');
        } catch (InvalidArgumentException|InvalidFileTypeException $e) {
            $this->session->set('update_profile_error', $e->getMessage());
            header('Location: /my-profile');
        }
    }
}