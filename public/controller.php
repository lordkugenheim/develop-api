<?php

include('../config/config.php');

$allowed_methods = [
    'GET',
    'POST',
    'PUT',
    'DELETE',
];

// block requests not in the allowed_methods
if (!in_array($_SERVER['REQUEST_METHOD'], $allowed_methods)) {
    die;
}

// get our vars from the url
$vars = explode('/', $_SERVER['REQUEST_URI']);
$params = array_slice($vars, 2);

// check the controller exists and load it
if (file_exists(DIR_CONTROL . $vars[1] . '.php')) {
    include_once(DIR_CONTROL . $vars[1] . '.php');
}

if (isset($return)) {
    $response = Response::getInstance();
    http_response_code($response->getHttpCode());
    echo $response->buildResponse();
}
