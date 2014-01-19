#!/usr/bin/php
<?php

$projectRootPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

require $projectRootPath . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$yaml = new \Symfony\Component\Yaml\Parser();
try {
    $file = $projectRootPath . 'config' . DIRECTORY_SEPARATOR . 'data.yml';
    $config = $yaml->parse(file_get_contents($file));
} catch (\Symfony\Component\Yaml\Exception\ParseException $e) {
    printf("Unable to parse the YAML string: %s", $e->getMessage());
    exit;
}

$setting = new \Ethmael\Domain\Settings($file);
$game = new \Ethmael\Domain\Game($setting);
$player = new \Ethmael\Domain\Player();

$game->startGame();


//$core = new \Ethmael\Kernel\Core($setting);
//$core->initCities($game); //OK
//$core->initTraders($game); //OK
//$core->dispatchTraders($game); //OK
//$pirate = $core->initPirate($game); //OK


$interpreter = new \Ethmael\Bin\Interpreter(new \Ethmael\Kernel\CommandLineResponse());
$interpreter->registerCommand(new \Ethmael\Bin\Command\Status($player, $game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\StatusDebug($player, $game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\VisitBoat($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\RenamePlayer($player));
$interpreter->registerCommand(new \Ethmael\Bin\Command\RenameBoat($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\BuyResourceToTrader($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\SellResourceToTrader($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\UpgradeBoat($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\Travel($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\CityList($game));

$console = new Ethmael\Bin\Console(STDIN);
$console->run(STDOUT, $interpreter);

