Colectiv-Backend-PHP

Install XAMPP with PHP 5.6 - https://www.apachefriends.org/ro/index.html<br/>
Create new folder /malvavisco-php in C:/xampp/htdocs and copy this project

( if you change the folder name to something like /colectiv, replace "/malvavisco-php" in .htaccess and /config/env.php )

Create database malvavisco and import from /migrate/database.sql<br/>
Create database malvavisco-test (without any import - this is used as mock database)

server location - http://localhost/malvavisco-php<br/>
to run all tests - http://localhost/malvavisco-php/test/run_tests.php - this will be eventually moved to command line, because it's INSECURE to allow anyone to run tests, but it's easier for now

( run_tests.php fetches all files from /test that start with "test_numeTest" and executes numeTest()->run() )<br/>
( at TEST runtime, the framework will dump all tables from malvavisco-test, it will import database.sql schema and it will populate it with test-data.sql -> in test-data put all your sql dummy data )
