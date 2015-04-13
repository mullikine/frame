<?php

class LocationSelectionModule extends BaseModule {

    const MAX_LOCATION_LENGTH = 10;

    protected $__file = __FILE__;

    private $region;
    private $locations;

    public function __construct($request) {
        parent::__construct();

        $regionUrl = $request['path'][0];

        $this->region = DataFacade::getRegionByUrlName($regionUrl);
        $this->locations = DataFacade::getLocationsByRegionID($this->region['id']);

        foreach($this->locations as &$location) {
            if (strlen($location['name']) > self::MAX_LOCATION_LENGTH) {
                $location['short_name'] = substr($location['name'], 0, self::MAX_LOCATION_LENGTH - 2) . '...';

            } else {
                $location['short_name'] = $location['name'];
            }

            $location['href'] = Frame::globals('baseUrl') . '/' . $this->region['url'] . '/' . $location['url'];
        }


        $this->addChildModule('Crumbs', new CrumbsModule($request));
    }

    protected function render() {

        $this->tmpl->setVariable('Region', $this->region);
        $this->tmpl->setLoop('LocationsLoop', $this->locations);

    }

}
?>
