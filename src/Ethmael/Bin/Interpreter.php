<?php

namespace Ethmael\Bin;

use Ethmael\Bin\Command\Command;
use Ethmael\Kernel\Request;
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

    public function consume(Request $request)
    {
        $this->response->reset();
        $alias = $request->getCommand();
        if (!isset($this->commands[$alias])) {
            $this->showAvailableCommands();
        } else {
            $command = $this->commands[$alias];
            $command->run($request, $this->response);
        }
    }

    public function showAvailableCommands()
    {
        $this->response->addLine('invalid command, try these ones:');
        foreach ($this->commands as $command) {
            $this->response->addLine($command->usage);
        }
    }

    public function getResponse()
    {
        return $this->response;
    }

}