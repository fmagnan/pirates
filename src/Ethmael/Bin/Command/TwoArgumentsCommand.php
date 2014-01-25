<?php

namespace Ethmael\Bin\Command;

use Ethmael\Kernel\Request;
use Ethmael\Kernel\Response;

abstract class TwoArgumentsCommand extends Command
{
    protected function getArguments(Request $request, Response $response)
    {
        if (false === strpos($request, ' ')) {
            $response->addLine('missing arguments!');
            return;
        }
        $argumentsInLine = preg_replace("/([^\s]*)(\s+)([^\s]*)(\s+)(.*)/", "$3 $5", $request);
        $arguments = explode(' ', $argumentsInLine);

        return $arguments;
    }
}