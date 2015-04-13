<?php

class RegionSelectionModule extends BaseModule {
    
    protected $__file = __FILE__;

    public function __construct($request) {
        parent::__construct();

        $this->addChildModule('Crumbs', new CrumbsModule($request));
    }

    protected function render() {

        $regions = DataFacade::getRegions();

        foreach($regions as &$region) {
            $region['href'] = Frame::globals('baseUrl') . '/' . $region['url'];
        }

        $this->tmpl->setLoop('RegionsLoop', $regions);

    }

}
?>
