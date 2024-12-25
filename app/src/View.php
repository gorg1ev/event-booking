<?php

namespace App;

use App\Exception\ViewNotFoundException;

class View
{


    public function __construct(protected string $view, protected array $params = [])
    {
    }

    public static function make(string $view, array $params = []): self
    {
        return new static($view, $params);
    }

    public function render(): string
    {

        $viewPath = VIEW_PATH . DIRECTORY_SEPARATOR . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException($this->view);
        }

        extract($this->params);

        ob_start();

        include $viewPath;

        return (string)ob_get_clean();
    }

    public function __toString(): string
    {
        try {
            return $this->render();
        } catch (ViewNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
            exit;
        }
    }
}