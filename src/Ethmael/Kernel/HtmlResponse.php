<?php

namespace Ethmael\Kernel;

class HtmlResponse extends Response
{
    public function __toString()
    {
        return implode('<br />', $this->lines);
    }
}