<?php

namespace Ethmael\Utils;

class Math
{
    public static function randomN($nb_a_tirer, $val_min, $val_max)
    {
        $tab_result = array();
        while ($nb_a_tirer != 0) {
            $nombre = mt_rand($val_min, $val_max);
            if (!in_array($nombre, $tab_result)) {
                $tab_result[] = $nombre;
                $nb_a_tirer--;
            }
        }

        return $tab_result;
    }
}