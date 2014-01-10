<?php

namespace Ethmael\Bin;

use Ethmael\Bin\Command\AbstractCommand;

class Interpreter
{
    use Writer;

    protected $commands;

    public function __construct()
    {
        $this->commands = [];
    }

    public function registerCommand(AbstractCommand $command)
    {
        $this->commands[$command->getAlias()] = $command;
    }

    protected function sanitizeCommand($command)
    {
        return trim(strtolower($command));
    }

    public function executeCommand($outputStream, $command)
    {
        $command = $this->sanitizeCommand($command);
        if ('help' === $command) {
            foreach ($this->commands as $item) {
                $this->out($outputStream, $item->usage());
            }
            return true;
        }
        if (!isset($this->commands[$command])) {
            $this->out($outputStream, 'invalid command, try "help" to get commands list.');
            return true;
        }
        return $this->commands[$command]->launch($outputStream);
    }
}