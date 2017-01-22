<?php

include_once MODEL_FOLDER . 'User.php';

// Pattern -> controller::method
$config['routes'] = array(
    'home' => 'Home:Home', // default / route, REQUIRED
    'dashboard/:section' => array(
        'logged' => true,
        'role' => Role::Admin,
        'action' => 'Home:getUsers',
        'method' => 'POST'
    ),
    'login' => array(
        'action' => 'Home:login',
        'method' => 'POST'
    ),
    'user/:name/:password' => 'Home:user',
    //'api/users' =>
);