<?php
/*
 * Minimalistic templating engine
 *
 * Supports: <loop name="LoopName">
 *              {LoopName.variable1} lorem ipsum {LoopName.variable2}
 *           <noloop name="LoopName">
 *              Fallback content if the loop array is empty
 *           </noloop name="LoopName">
 *           </loop name="LoopName">
 *
 * Supports: {Variable.Key}
 *           
 */

class Template {

    private $vars = array();
    private $loops = array();
    private $body = '';

    public function setBody($body) {
        $this->body = $body;
    }

    public function setVariable($var_name, &$var_value) {
        if (is_array($var_value)) {
            foreach($var_value as $key => &$value) {
                $this->setVariable($var_name . '.' . $key, $value);
            }
        }
        else {
            $this->vars[$var_name] = &$var_value;
        }
    }

    public function setLoop($loop_name, &$loop) {
        if (isset($loop)) {
            $this->loops[$loop_name] = &$loop;
        }
    }


    private function parseLoops(&$str) {

        foreach($this->loops as $loopName => &$loopArray) {
            $startTag = '<loop name="'.$loopName.'">';
            $endTag = '</loop name="'.$loopName.'">';
            $startTagPos = strpos($str, $startTag);
            if ($startTagPos === false) {
                continue;
            }

            $startLoopCodePos = $startTagPos + strlen($startTag);
            $endLoopCodePos = strpos($str, $endTag);

            $loopCode = substr($str, $startLoopCodePos, $endLoopCodePos-$startLoopCodePos);
            if ($loopCode === false) {
                continue;
            }

            $oldLoopCode = $loopCode;
            $newCode = '';

            $noloopStartTag = '<noloop name="'.$loopName.'">';
            $noloopEndTag = '</noloop name="'.$loopName.'">';
            $noloopStartPos = strpos($loopCode, $noloopStartTag);

            if ($noloopStartPos !== false) {
                $noloopBodyPos = $noloopStartPos + strlen('<noloop name="'.$loopName.'">');
                $noloopEndPos = strpos($loopCode, '</noloop name="'.$loopName.'">');
                $noloopCode = substr($loopCode, $noloopBodyPos, $noloopEndPos - $noloopBodyPos);
                $loopCode = str_replace($noloopStartTag.$noloopCode.$noloopEndTag, '', $loopCode);
            }

            if (is_array($loopArray)) {
                $keys = array_keys($loopArray);
                $len = count($keys);
                for($i = 0; $i < $len; $i++) {
                    $temp_code = $loopCode;
                    foreach($loopArray[$keys[$i]] as $key => $value) {
                        $temp_code = str_replace( '{'. $loopName. '.' .$key. '}', $value, $temp_code);
                    }
                    $newCode .= $temp_code;

                }
            } elseif ($noloopCode !== false) {
                $newCode = $noloopCode;
            }
            $str = str_replace($startTag.$oldLoopCode.$endTag, $newCode, $str);

        }

        return $str;
    }

    private function parseVariables(&$str) {
        
        foreach($this->vars as $key => &$value) {
            $tag = '<!--{'.$key.'}-->';
            $str = str_replace($tag, $value, $str);
            $tag = '{'.$key.'}';
            $str = str_replace($tag, $value, $str);
        }

        return $str;
    }

    public function process() {
        return $this->parseVariables($this->parseLoops($this->body));
    }

}

?>