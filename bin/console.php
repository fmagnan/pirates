<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$console = new Ethmael\Bin\Console(STDIN);
$interpreter = new \Ethmael\Bin\Interpreter();
$interpreter->registerCommand(new \Ethmael\Bin\Command\ExitCommand());
$console->useInterpreter($interpreter);
$console->run(STDOUT, 'Welcome in Pirates! Game Of The Year Edition.');