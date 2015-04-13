<?php

$config = array();

// Production //
$config['nzchannels.unitlink.org'] = array(
    'databaseUser' => 'unitlink_nzchan1',
    'databasePass' => '',
    'databaseHost' => 'localhost',
    'databaseName' => 'unitlink_nzchannels1',

    'baseUrl' => 'http://nzchannels.unitlink.org',

    'logging' => 'off'
);
$config['www.nzchannels.unitlink.org'] = $config['nzchannels.unitlink.org'];

// Localhost //
$config['localhost'] = array(
    'databaseUser' => 'root',
    'databasePass' => '',
    'databaseHost' => 'localhost',
    'databaseName' => 'unitlink_nzchannels1',

    'baseUrl' => 'http://localhost/nzchannels/shane',

    'logging' => 'on'
);

?>