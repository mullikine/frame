<?php
class TextUtils {

    public static function stripSlashesArray(&$array) {
        foreach($array as $key => $value) {
            if (is_array($array[$key])) {
                $array[$key] = stripSlashesArray($array[$key]);
            } else {
                $array[$key] = stripslashes($array[$key]);
            }
        }
        return $array;
    } //end stripSlashesArray


    public static function url2link($text) {
        $text = preg_replace('!(^|([^\'"]\s*))' . '([hf][tps]{2,4}:\/\/[^\s<>"\'()]{4,})!mi', '$2<a href="$3">$3</a>', $text);
        $text = preg_replace('!<a href="([^"]+)[\.:,\]]">!', '<a href="$1">', $text);
        $text = preg_replace('!([\.:,\]])</a>!', '</a>$1', $text);
        return $text;
    }

    public static function stripTags($text) {
        $text = strip_tags($text, '<a><strong><b><em>');
        return preg_replace('/<(.*?)>/ie', "'<'.TextUtils::stripAttributes('\\1').'>'", $text);
    }

    public static function stripAttributes($tagSource) {
        $stripAttrib = 'javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|'.
                'onmousemove|onmouseout|onkeypress|onkeydown|onkeyup|onload|onunload';
        return stripslashes(preg_replace("/$stripAttrib/i", '#', $tagSource));
    }

    public static function startsWith($haystack, $needle, $case = true) {
        if($case) {
            return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);
        }
        return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
    }

    public static function endsWith($haystack, $needle, $case = true) {
        if($case) {
            return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle) === 0);
        }
        return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle) === 0);
    }
}
?>
