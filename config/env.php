<?php

$config['env'] = array(
    'base_url' => '/malvavisco-php',
    'response_type' => 'json', // text | json
    'default_include' => array(
        // include this in index.php so it's visible everywhere
        SERVICE_FOLDER . 'ConfigService.php',
        SERVICE_FOLDER . 'DBService.php',
        SERVICE_FOLDER . 'SessionService.php',
        SERVICE_FOLDER . 'AuthService.php',
        SERVICE_FOLDER . 'LogService.php',
        REPOSITORY_FOLDER . 'AbstractRepository.php',
        CONTROLLER_FOLDER . 'BaseController.php',
    ),
    'auth_header' => 'Authorization',
    'secret_key' => '0180i3hfnbu2bg9ug1hu9cb19ugcd1[i',
    'token_expire_time' => 3600, // seconds
);