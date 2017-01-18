<?php


// Pattern: controller::method
$config['routes'] = array(
    'home' => 'Home:Home', // default / route, REQUIRED
    'login' => 'Home:login',
    'user/:name/:password' => 'Home:user'
);