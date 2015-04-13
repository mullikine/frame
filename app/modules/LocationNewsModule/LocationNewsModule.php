<?php

class LocationNewsModule extends BaseModule {

    protected $__file = __FILE__;

    private $location;
    private $mediaTypes;

    public function __construct($request) {
        parent::__construct();

        $locationUrl = $request['path'][1];

        
        $this->location = DataFacade::getLocationByUrlName($locationUrl);
        $this->mediaTypes = DataFacade::getMediaTypes();


        $this->addChildModule('Crumbs', new CrumbsModule($request));
    }

    protected function render() {

        $this->tmpl->setVariable('Location', $this->location);
        $this->tmpl->setLoop('MediaTypesLoop', $this->mediaTypes);

    }

}
?>
