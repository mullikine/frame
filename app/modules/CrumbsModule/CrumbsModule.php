<?php

class CrumbsModule extends BaseModule {

    protected $__file = __FILE__;

    private $crumbs = array();
    private $activeCrumb = array();


    public function __construct($request) {
        parent::__construct();

        $path = $request['path'];
        $base = Frame::globals('baseUrl');

        switch(count($path)) {
            case 0:
                $this->activeCrumb = array('name' => 'NZ');
                break;
            case 1:
                $this->crumbs[] = array('name' => 'NZ', 'href' => $base);
                $region = DataFacade::getRegionByUrlName($path[0]);
                $this->activeCrumb = array('name' => $region['name']);
                break;
            case 2:
                $this->crumbs[] = array('name' => 'NZ', 'href' => $base);
                $region = DataFacade::getRegionByUrlName($path[0]);
                $this->crumbs[] = array('name' => $region['name'], 'href' => $base . '/' . $region['url']);
                $location = DataFacade::getLocationByUrlName($path[1]);
                $this->activeCrumb = array('name' => $location['name']);
                break;
        }


    }


    protected function render() {
        $this->tmpl->setLoop('CrumbsLoop', $this->crumbs);
        $this->tmpl->setVariable('ActiveCrumb', $this->activeCrumb);
    }
    


}

?>
