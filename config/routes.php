<?php

include_once MODEL_FOLDER . 'User.php';

// Pattern -> controller::method
$config['routes'] = array(
    'home' => 'Home:Home', // default / route, REQUIRED
//    'dashboard/:section' => array(
//        'logged' => true,
//        'role' => Role::SuperAdmin,
//        'action' => 'Home:getUsers',
//        'method' => 'POST'
//    ),
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
    ),
    'flux/create' => array(
        'action' => 'Flux:create',
        'method' => 'POST',
        'logged' => true
    ),
    'flux/:fluxId/add/:documentId' => array(
        'action' => 'Flux:addDocument',
        'method' => 'PUT',
        'logged' => true
    ),
    'flux/getall' => array(
        'action' => 'Flux:getAll',
        'method' => 'GET',
        'logged' => true
    ),
    'flux/getall/:status' => array(
        'action' => 'Flux:getAll',
        'method' => 'GET',
        'logged' => true
    ),
    'flux/getpending' => array(
        'action' => 'Flux:getPending',
        'method' => 'GET',
        'logged' => true
    ),
    'flux/get/:fluxId' => array(
        'action' => 'Flux:getOne',
        'method' => 'GET',
        'logged' => true
    ),
    'flux/documents/:fluxId' => array(
        'action' => 'Flux:getDocuments',
        'method' => 'GET',
        'logged' => true
    ),
    'flux/update/:fluxId' => array(
        'action' => 'Flux:update',
        'method' => 'PUT',
        'logged' => true
    ),
    'flux/delete/:fluxId' => array(
        'action' => 'Flux:delete',
        'method' => 'DELETE',
        'logged' => true
    ),
    'flux/accept/:fluxId' => array(
        'action' => 'Flux:accept',
        'method' => 'POST',
        'logged' => true
    ),
    'flux/reject/:fluxId' => array(
        'action' => 'Flux:reject',
        'method' => 'POST',
        'logged' => true
    ),
    'user/create' => array(
        'action' => 'User:create',
        'method' => 'POST',
        //'logged'=>true
    ),
    'user/get/:userId' => array(
        'action' => 'User:getOne',
        'method' => 'POST',
        '//logged' => true,
    ),
    'user/update/:userId' => array(
        'action' => 'User:update',
        'method' => 'PUT',
        'logged' => true,
        'role' => Role::SuperAdmin,
    ),
    'user/delete/:userId' => array(
        'action' => 'User:delete',
        'method' => 'PUT',
        'logged' => true,
        'role' => Role::SuperAdmin,
    )

);