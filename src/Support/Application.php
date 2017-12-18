<?php

namespace Cenoura\Support;

use Cenoura\Common\Library\Container\Container;

class Application extends Container
{
    public function __construct(array $values = [])
    {
        parent::__construct($values);
    }

    public function loadConfigFiles($directory)
    {
        try {
            $dirFiles = new \DirectoryIterator($directory);

            foreach ($dirFiles as $file) {
                if ($file->isFile() && $file->getExtension() == 'php') {
                    require $file->getPathname();
                }
            }
        } catch (\UnexpectedValueException $e) {
            echo 'Invalid config directory provided.';
        }
    }

    public function getController()
    {
        $controller = filter_input(
            INPUT_GET,
            'controller',
            FILTER_SANITIZE_SPECIAL_CHARS
        );

        if (empty($controller)) {
            $controller = 'movie';
        }

        if (!$this->offsetExists($controller . '.controller')) {
            throw new \Exception('Controller not found.');
        }

        return $this[$controller . '.controller'];
    }

    public function getAction()
    {
        $action = filter_input(
            INPUT_GET,
            'action',
            FILTER_SANITIZE_SPECIAL_CHARS
        );

        if (empty($action)) {
            $action = 'index';
        }

        if (!method_exists($this->getController(), $action)) {
            throw new \Exception('Action not found on controller.');
        }

        return $action;
    }
}