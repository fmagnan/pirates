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

$core = new \Ethmael\Kernel\Core($config);
$game = new \Ethmael\Domain\Game();
$player = new \Ethmael\Domain\Player();

$core->initCities($game);
$core->initTraders($game);
$core->dispatchTraders($game);
$pirate = $core->initPirate($game);


$interpreter = new \Ethmael\Bin\Interpreter(new \Ethmael\Kernel\CommandLineResponse());
$interpreter->registerCommand(new \Ethmael\Bin\Command\Status($player, $game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\StatusDebug($player, $game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\VisitBoat($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\RenamePlayer($player));
$interpreter->registerCommand(new \Ethmael\Bin\Command\RenameBoat($game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\BuyResourceToTrader($core, $game));
$interpreter->registerCommand(new \Ethmael\Bin\Command\Travel($core, $game));

$console = new Ethmael\Bin\Console(STDIN);
$console->run(STDOUT, $interpreter);

