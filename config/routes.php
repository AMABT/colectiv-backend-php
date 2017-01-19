<?php

include_once MODEL_FOLDER . 'User.php';

// Pattern -> controller::method
$config['routes'] = array(
    'home' => 'Home:Home', // default / route, REQUIRED
    'login' => 'Home:login',
    'user/:name/:password' => 'Home:user',
    'getUsers' => 'Home:getUsers',
    'dashboard/:section' => array(
        'logged' => true,
        'role' => Role::Admin,
        'action' => 'Home:user'
    )
);