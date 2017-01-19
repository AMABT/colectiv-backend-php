Colectiv-Backend-PHP

Install XAMPP with PHP 7.0
Extract /malvavisco-php to /htdocs (folder in XAMPP)

( if you change the folder name to something like /colectiv, replace "/malvavisco-php" in .htaccess and /config/env.php )

Create database malvavisco and import from /migrate/database.sql
Create database malvavisco-test (without any import)

server location - http://localhost/malvavisco-php
to run all tests - http://localhost/malvavisco-php/test/run_tests.php - this will be eventually moved to command line, because it's INSECURE to allow anyone to run tests

( run_tests.php fetches all files from /test that start with "test_numeTest" and executes numeTest()->run() )
( at test runtime, the framework will dump all tables from malvavisco-test and it will import database.sql schema and it will populate it with test-data.sql -> in test-data put all your sql dummy data )
