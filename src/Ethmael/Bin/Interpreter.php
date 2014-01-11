<?php

namespace Ethmael\Bin;

use Ethmael\Bin\Command\Command;
use Ethmael\Kernel\Response;

class Interpreter
{
    protected $commands;
    protected $response;

    public function __construct(Response $response)
    {
        $this->commands = [];
        $this->response = $response;
    }

    public function registerCommand(Command $command)
    {
        $this->commands[$command->alias] = $command;
    }

    protected function sanitizeCommand($command)
    {
        return trim(strtolower($command));
    }

    public function consume($request)
    {
        $this->response->reset();
        if (!$this->isRequestUnderstood($request)) {
            $this->showAvailableCommands();
        } else {
            $command = $this->commands[$request];
            $command->run($this->response);
        }
    }

    public function showAvailableCommands()
    {
        $this->response->addLine('invalid command, try these ones:');
        foreach ($this->commands as $command) {
            $this->response->addLine($command->usage);
        }
    }

    public function isRequestUnderstood($request)
    {
        return isset($this->commands[$request]);
    }

    public function getResponse()
    {
        return $this->response;
    }

}