<?php


// Pattern: controller::method
$config['routes'] = array(
    'home' => 'Home:Home', // default / route, REQUIRED
    'salut/:value' => 'Home:Hello',
    'salut/bine/:value' => 'Home:hello',
    'salut/:value/:name' => 'Home:Hello',
    'getUsers' => 'Home:getUsers',
);