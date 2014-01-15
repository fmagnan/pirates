<?php

namespace Ethmael\Utils;

class Math
{
    /**
     * Random function that return an array of values :
     * - All values are different
     * - All values are between a min and a max.
     * @nbValues : number of values to return randomly
     * @valMin : minimum value for values to return
     * @valMax : maximum value for values to return
     * return : array with all the random values
     * Exception : RangeException if valMax - valMin < nbValues
     * Exception : RangeException if valMax <= valMin
     */
    public static function randomN($nbValues, $valMin, $valMax)
    {
        if ($valMax <= $valMin) {
            $message = sprintf('valMax <= valMin (%d <= %d)', $valMax, $valMin);
            throw new \RangeException($message);
        }

        if (($valMax - $valMin)<$nbValues-1) {
            $message = sprintf('Not possible to get %d values between %d and %d', $nbValues,$valMin, $valMax);
            throw new \RangeException($message);
        }

        $tab_result = array();
        while ($nbValues != 0) {
            $number = mt_rand($valMin, $valMax);
            if (!in_array($number, $tab_result)) {
                $tab_result[] = $number;
                $nbValues--;
            }
        }
        return $tab_result;
    }


}