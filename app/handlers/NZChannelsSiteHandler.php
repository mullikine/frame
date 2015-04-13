<?php

class NZChannelsSiteHandler {
    
    public static function handleRequest($request) {

        DataFacade::connect($request['config']);

        $page = new NZChannelsSiteModule($request);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $page->processPostEventsTree();
        }

        echo $page->toHTML();
        
    }
}

?>
