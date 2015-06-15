<?php

$conf = array(
    'production' => array(
        'db_name' => 'artcmsdb',
        'development_mode' => false
    ),
    'development' => array(
        'db_name' => 'artcmsdb',
        'db_host' => 'localhost',
        'db_user' => 'root',
        'db_pass' => '',
        'development_mode' => true
    ),
    'staging' => array(
        'db_name' => 'artcmsdb',
        'db_host' => 'localhost',
        'db_user' => 'root',
        'db_pass' => '',
        'development_mode' => true
    )
);

return $conf['development'];

