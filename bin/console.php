<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$console = new Ethmael\Bin\Console(STDIN, STDOUT);
$console->run('Welcome in Pirates! Game Of The Year Edition.');