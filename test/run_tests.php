<?php

/**
 * Get all files from this folder and run all tests
 */

include_once 'assert.php';
include_once 'TestClass.php';

// Get all files from current directory
$test_files = scandir(dirname(__FILE__));

foreach ($test_files as $file) {

    // if filename is test_something.php
    if (strstr($file, 'test_') > 0 && strstr($file, '.php') > 0) {

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
