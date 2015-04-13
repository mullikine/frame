<?php

class Frame {
    
    public static $globals = array();

    public static function addGlobals($dict) {
        foreach($dict as $key => $value) {
            self::$globals[$key] = $value;
        }
    }

    public static function globals($key) {
        return self::$globals[$key];
    }

}

?>
