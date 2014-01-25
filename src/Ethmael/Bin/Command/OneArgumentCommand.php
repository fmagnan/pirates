<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;

abstract class OneArgumentCommand extends Command
{
    protected function getArgument(Request $request, Response $response)
    {
        if (false === strpos($request, ' ')) {
            $response->addLine('missing argument!');
            return;
        }
        return preg_replace('/([^\s]*)(\s+)(.*)/','$3', $request);
    }
}