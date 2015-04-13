<?php

// site structure definition

$sitedef = array(

        '/ajax' => array(
            'handler' => 'NZChannelsAjaxHandler'
        ),

        '/' => array(
            'handler' => 'NZChannelsSiteHandler'
        )
);

?>