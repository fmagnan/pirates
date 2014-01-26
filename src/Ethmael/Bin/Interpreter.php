<?php

namespace Ethmael\Bin;

use Ethmael\Bin\Command\Command;
use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;

class Interpreter
{
    protected $commands;
    protected $response;
    protected $colorizer;

    public function __construct(Response $response)
    {
        $this->commands = [];
        $this->response = $response;
        $this->colorizer = new Colorizer();
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
        $this->response->addLine('Usage:');
        $this->response->addLine('  command [arguments]'.PHP_EOL);
        foreach ($this->commands as $command) {
            $alias = $this->colorizer->green($command->alias);
            $usage = $command->usage;
            $this->response->addLine(str_pad($alias, 25) . $usage);
        }
    }

    public function getResponse()
    {
        return $this->response;
    }

}