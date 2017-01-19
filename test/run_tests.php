<?php

/**
 * Get all files from this folder and run all tests
 */

define('IS_TEST_ENV', true);

include_once 'assert.php';
include_once 'TestClass.php';
include_once __DIR__ . '/../index.php';

// Get all files from current directory
$test_files = scandir(dirname(__FILE__));

echo '<pre>';

foreach ($test_files as $file) {

    // if filename is test_something.php
    if (strstr($file, 'test_') && strstr($file, '.php')) {

        include_once $file;

        // keep only "something"
        $name = str_replace('test_', '', $file);
        $name = str_replace('.php', '', $name);

        $name = ucfirst($name) . 'Test';

        // init SomethingTest and run

        /* @var $test TestClass */
        $test = new $name();

        if ($test instanceof TestClass) {
            $test->run();
        }
    }
}

echo '</pre>';
