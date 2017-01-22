<?php

include_once MODEL_FOLDER . 'User.php';

// Pattern -> controller::method
$config['routes'] = array(
    'home' => 'Home:Home', // default / route, REQUIRED
    'dashboard/:section' => array(
        'logged' => true,
        'role' => Role::SuperAdmin,
        'action' => 'Home:getUsers',
        'method' => 'POST'
    ),
    'login' => array(
        'action' => 'Home:login',
        'method' => 'POST'
    ),
    'document/upload' => array(
        'action' => 'Document:upload',
        'method' => 'POST',
        'logged' => true,
    ),
    'document/getall' => array(
        'action' => 'Document:getAll',
        'method' => 'GET',
        'logged' => true
    ),
    'document/delete/:documentId' => array(
        'action' => 'Document:delete',
        'method' => 'DELETE',
        'logged' => true
    ),
    'document/download/:documentId' => array(
        'action' => 'Document:download',
        'method' => 'GET',
        'logged' => true
    )

);