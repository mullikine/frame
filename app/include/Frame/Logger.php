<?php
class Logger {
    private static $log = array();

    public static function log($message) {
        self::$log[] = $message;

        if (strtolower(Frame::globals('logging')) === 'on') {
            echo $message . "<br>\n";
        }
    }
}
?>
