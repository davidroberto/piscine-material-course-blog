<?php


namespace App\Utility;


class StringUtility
{

    public function reverseString($string)
    {
        return strrev(strtoupper($string));
    }

}
