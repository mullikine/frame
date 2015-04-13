<?php
class FileUtils {

    public static function getFileList($folder) {

        $dir = @opendir($folder);
        if (!$dir) {
            return array();
        }

        $files = array();

        while (($file = @readdir($dir)) !== false) {
            if($file != "." && $file != "..") {
                $files[] = $file;
            }
        }
        @closedir($dir);
        sort($files);
        return $files;
    }

}

?>
