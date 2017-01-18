<?php

$config['env'] = array(
    'base_url' => '/malvavisco-php',
    'response_type' => 'json', // text | json
    'default_include' => array(
        // include this in index.php so it's visible everywhere
        SERVICE_FOLDER . 'ConfigService.php',
        SERVICE_FOLDER . 'DBService.php',
        SERVICE_FOLDER . 'SessionService.php',
        CONTROLLER_FOLDER . 'BaseController.php',
    )
);