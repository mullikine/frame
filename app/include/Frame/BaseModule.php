<?php

abstract class BaseModule {

    protected $__file = __FILE__;
    protected $tmpl;
    protected $tmplFile = '';
    protected $children = array();

    public function __construct() {
        $this->tmpl = new Template();
    }

    protected function processPostEvents() {
    }

    protected function render() {
    }

    protected function addChildModule($name, $module) {
        $this->children[$name] = $module;
    }

    public function processPostEventsTree() {

        $this->processPostEvents();

        foreach($this->children as $child) {
            if (!$child->processPostEventsTree()) {
                return false;
            }
        }
        return true;
    }

    public function template() {
        if ($this->tmplFile !== '' && file_exists($this->tmplFile)) {
            return file_get_contents($this->tmplFile);
        } else if ($this->__file !== __FILE__) {
            $tmplFile = substr($this->__file, 0, -3) . 'html';
            return file_get_contents($tmplFile);
        } else {
            return '';
        }
    }

    public function toHTML() {

        $this->tmpl->setBody($this->template());
        $this->tmpl->setVariable('base_url', Frame::$globals['baseUrl']);
        $this->tmpl->setVariable('baseUrl', Frame::$globals['baseUrl']);

        $this->render();

        foreach($this->children as $name => $child) {
            $this->tmpl->setVariable($name, $child->toHTML());
        }

        return $this->tmpl->process();
    }

}

?>
