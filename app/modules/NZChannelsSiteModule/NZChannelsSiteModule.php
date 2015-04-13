<?php

class NZChannelsSiteModule extends BaseModule {

    protected $__file = __FILE__;

    private $regions;

    public function __construct($request) {
        parent::__construct();

        $this->regions = DataFacade::getRegions();


        if (!$this->validateRequest($request)) {
            RequestHandler::redirect('/');
            exit();
        }

        $path = $request['path'];

        switch(count($path)) {
            case 0:
                $this->addChildModule('ContentModule', new RegionSelectionModule($request));
                break;

            case 1:
                $this->addChildModule('ContentModule', new LocationSelectionModule($request));
                break;

            case 2:
                $this->addChildModule('ContentModule', new LocationNewsModule($request));
                break;
        }
        
    }

    protected function validateRequest($request){

        $path = $request['path'];

        switch(count($path)) {
            case 0:
                return true;
                break;
            
            case 1:
                return isset($this->regions[$path[0]]);
                break;

            case 2:
                if (!isset($this->regions[$path[0]])) {
                    return false;
                }
                $locations = DataFacade::getLocationsByRegionID($this->regions[$path[0]]['id']);
                return isset($locations[$path[1]]);
                break;
        }

        return false;

    }


}

?>
