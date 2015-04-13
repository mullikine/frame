<?php

class DataFacade extends MySQLWrap {

    public static function getRegions() {
        
        $regions = MySQLWrap::selectEntities('regions');

        foreach($regions as $index => $region) {
            $regions[$region['url']] = $region;
            unset($regions[$index]);
        }

        return $regions;

    }

    public static function getMediaTypes() {

        $types = MySQLWrap::selectEntities('media_types');

        foreach($types as $index => $type) {
            $types[$type['url']] = $type;
            unset($types[$index]);
        }

        return $types;

    }

    public static function getRegionByUrlName($regionUrlName) {
        $regions = MySQLWrap::selectEntities('regions', array('url' => $regionUrlName));
        return $regions[0];
    }

    public static function getLocationsByRegionID($regionID) {

        $sql = 'SELECT * FROM `locations` ' .
            'WHERE region_id = '. $regionID . ' '.
            'ORDER BY locations.name';

        $locations = MySQLWrap::select($sql);


        foreach($locations as $index => $location) {
            $locations[$location['url']] = $location;
            unset($locations[$index]);
        }

        return $locations;
    }

    public static function getLocationByUrlName($locationUrlName) {
        $locations = MySQLWrap::selectEntities('locations', array('url' => $locationUrlName));
        return $locations[0];
    }


}
?>
