<?php

namespace Ethmael\Bin;

class Colorizer
{

    const BLACK = "0;30";
    const BLUE = "0;34";
    const GREEN = "32";
    const CYAN = "36";
    const RED = "31";
    const PURPLE = "0;35";
    const LIGHT_GRAY = "0;37";
    const DARK_GREY = "30";
    const LIGHT_BLUE = "1;34";
    const LIGHT_GREEN = "1;32";
    const LIGHT_CYAN = "1;36";
    const LIGHT_RED = "31";
    const LIGHT_PURPLE = "1;35";
    const YELLOW = "33";
    const WHITE = "1;37";

    protected function out($text, $color)
    {
        return "\033[" . $color . "m" . $text . "\033[0m";
    }

    public function yellow($text)
    {
        return $this->out($text, self::YELLOW);
    }

    public function red($text)
    {
        return $this->out($text, self::RED);
    }

    public function green($text)
    {
        return $this->out($text, self::GREEN);
    }

    public function cyan($text)
    {
        return $this->out($text, self::CYAN);
    }

    public function lightRed($text)
    {
        return $this->out($text, self::LIGHT_RED);
    }

    public function horizontalRule()
    {
        return $this->out(str_pad('-', 80, '-'), self::DARK_GREY);
    }
}