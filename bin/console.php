<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$game = new \Ethmael\Domain\Game();
$player = new \Ethmael\Domain\Player('Jaime');
$registry = new \Ethmael\Kernel\Registry();
$registry->bindGame($game);
$registry->bindPlayer($player);

$interpreter = new \Ethmael\Bin\Interpreter(new \Ethmael\Kernel\CommandLineResponse());
$interpreter->registerCommand(new \Ethmael\Bin\Command\Status($registry));
$interpreter->registerCommand(new \Ethmael\Bin\Command\Launch($registry));
$interpreter->registerCommand(new \Ethmael\Bin\Command\VisitBoat($registry));
$interpreter->registerCommand(new \Ethmael\Bin\Command\RenamePlayer($registry));
$interpreter->registerCommand(new \Ethmael\Bin\Command\RenameBoat($registry));
$interpreter->registerCommand(new \Ethmael\Bin\Command\BuyResourceToTrader($registry));

$console = new Ethmael\Bin\Console(STDIN);
$console->run(STDOUT, $interpreter);

