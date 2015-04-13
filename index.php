<?php

include_once('config.php');
include_once('sitedef.php');

include_once('app/include/Frame/AutoLoader.php');

// load site specific configuration
$config = $config[$_SERVER['SERVER_NAME']];

// set auto-include search folder
AutoLoader::addSearchDir('app');

// register framework values
Frame::addGlobals($config);

// handle the page request
RequestHandler::handleRequest($config, $sitedef);

?>