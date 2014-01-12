<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$core = new \Ethmael\Kernel\Core();
$game = new \Ethmael\Domain\Game();
$player = new \Ethmael\Domain\Player();

$interpreter = new \Ethmael\Bin\Interpreter(new \Ethmael\Kernel\CommandLineResponse());
$interpreter->registerCommand(new \Ethmael\Bin\Command\Status($player, $game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\Launch($core, $game, $player));
$interpreter->registerCommand(new \Ethmael\Bin\Command\VisitBoat($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\RenamePlayer($player));
$interpreter->registerCommand(new \Ethmael\Bin\Command\RenameBoat($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\BuyResourceToTrader($core, $game));

$console = new Ethmael\Bin\Console(STDIN);
$console->run(STDOUT, $interpreter);

