<?php


abstract class MClasses {

    /**
     * Checks if a class is a valid class
     * @param string $class
     * @return boolean
     */
    public function checkClass($class) {
        $test = false;

        foreach ( MClasses::getConstants() as $key => $value ) {
            if (strtolower($class) == strtolower($key)) {
                $test = true;
            }
        }

        if (! $test) {
            new MError ( "Class you would like to set isn't registred yet! Classname given:" . $classe );
            return false;
        }

        return true;
    }

    static function getConstants() {
        $classes = array("LOGIN" => "Login",
            "USER" => "User",
            "USERLOG" => "UserLog"
        );
        return $classes;
    }



}
