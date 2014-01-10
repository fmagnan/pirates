<?php

namespace Ethmael\Bin;

trait Writer
{
    public function out($outputStream, $message, $addEndOfLine = true)
    {
        if ($addEndOfLine) {
            $message .= PHP_EOL;
        }
        fwrite($outputStream, $message);
    }
}