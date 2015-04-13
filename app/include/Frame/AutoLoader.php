<?php

// Autoloader class.

// Usage: include this file, do AutoLoader::addSearchDir('path/to/php/files');
// All classes should be automatically loaded from files named ClassName.php

class AutoLoader {

    private static $dirs = array();

    private static function loadr($base, $classname) {
        if (file_exists($base.'/'.$classname.'.php')) {
            require_once($base.'/'.$classname.'.php');
            return true;
        } else if (file_exists($base.'/'.$classname.'.class.php')) {
            require_once($base.'/'.$classname.'.class.php');
            return true;
        }

        $dir = opendir($base);
        while ($dir && ($file = readdir($dir)) !== false) {
            if (is_dir($base.'/'.$file) && $file != '..' && $file != '.') {
                if (AutoLoader::loadr($base.'/'.$file, $classname)) {
                    return true;
                }
            }
        }
        return false;
    }


    public static function load($classname) {
        
        $classpath = explode('\\', $classname);
        $classname = $classpath[count($classpath) - 1];

        //echo 'Looking for: ' . $classname . '<br />';
        $base = dirname(__FILE__);
        if (!AutoLoader::loadr($base, $classname)) {
            foreach (AutoLoader::$dirs as $dir) {
                if (AutoLoader::loadr($dir, $classname)) {
                    break;
                }
            }
        } else {
            //echo $classname . ' found in: ' . $base . '<br />';
        }
    }

    public static function addSearchDir($dir) {
        AutoLoader::$dirs[] = $dir;
    }

}

spl_autoload_register(array('AutoLoader', 'load'));
?>
