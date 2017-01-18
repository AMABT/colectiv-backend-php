<?php

/**
 * Required headers for REST
 */
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: false');
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Headers: X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept');


/**
 * Main entry point for application
 */

define('CONFIG_FOLDER', 'config/');
define('CONTROLLER_FOLDER', 'controller/');
define('MODEL_FOLDER', 'model/');
define('REPOSITORY_FOLDER', 'repository/');
define('SERVICE_FOLDER', 'service/');

include_once CONFIG_FOLDER . "env.php";
include_once CONFIG_FOLDER . "routes.php";


/**
 * Include all default files
 */

foreach ($config['env']['default_include'] as $file) {
    include_once $file;
}

// get current url - ex: /malvavisco-php/user/add
$url = $_SERVER['REQUEST_URI'];
// replace base directory and remove start and end slashes
$url = str_replace(trim($config['env']['base_url'], "/"), '', trim($url, "/"));
// remove first and last slash for consistency
$url = strtolower(trim($url, "/"));
// transform it into array
$url_array = explode('/', $url);

// get routes config
$routes = $config['routes'];

$action_args = array();
$action = null;

if (empty($url) || $url == "/") {

    $action = $routes['home'];

} else {

    // foreach all routes to search for a match
    foreach ($routes as $route_key => $route_action) {

        if (empty($route_key)) {
            continue;
        }

        // transform config route into array and foreach each part to check match with url
        // $route_key = "getUsers/:userId" becomes $route = array("getusers", ":userid")
        $route = explode("/", trim(strtolower($route_key), "/"));

        // if count of $url_array does not match $route array, there is something missing, move to next route
        if (count($route) != count($url_array)) {
            continue;
        }

        // $key is index -> 0,1,2....
        foreach ($route as $key => $route_part) {

            if (!empty($url_array[$key])) {

                // if it's not a match with the url and not a param too
                if ($route_part[0] != ":" && $route_part != $url_array[$key]) {
                    break;
                }

                // save param - $route_part = ":userid" and $url_array[$key] = 20
                if ($route_part[0] == ":") {
                    $action_args[] = $url_array[$key];
                }

                // save route action - $action = Home:getUsers
                $action = $route_action;
            }
        }

        if (!empty($action)) {
            break;
        }

    }
}

if (!empty($action)) {

    $action = explode(":", $action);

    $controller = ucfirst($action[0]) . "Controller";
    $method = strtolower($action[1]) . "Action";

    // include controller
    include_once CONTROLLER_FOLDER . $controller . ".php";

    // init route controller
    $controller = new $controller();

    // TODO implement BaseController->checkLoggedAndRedirect() for routes

    // method found, call controller method with args from url
    echo call_user_func_array(array($controller, $method), $action_args);

    // stop execution
    return;
}

?>

<div style="text-align: center;">
    <h1>404</h1>
    <p>Route not found</p>
</div>