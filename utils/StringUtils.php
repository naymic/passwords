<?php

/**
 * Created by PhpStorm.
 * User: micha
 * Date: 16/07/17
 * Time: 14:44
 */
class StringUtils{


    public static function setFirstLetterToUpper(string $string):string{

        $firstletter = strtoupper(substr($string,0,1));
        $string = substr_replace($string,$firstletter,0,1);

        return $string;
    }


}