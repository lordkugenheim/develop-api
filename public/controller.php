<?php

$includeFiles = array_merge(glob("../config/*.php"), glob("../classes/*.php"));

foreach ($includeFiles as $filename) {
    include $filename;
}

$response = Core\Response::getInstance();

// block requests not in the allowed_methods
if (!in_array($_SERVER['REQUEST_METHOD'], ALLOWED_METHODS)) {
    $response->setHttpCode(405);
    $response->addHeader('Allow: ' . implode(',', ALLOWED_METHODS));
    $response->addOutput(['error', 'Invalid request method. Allowed methods are ' . implode(', ', ALLOWED_METHODS)]);
}

// get our vars from the url
$vars = explode('/', $_SERVER['REQUEST_URI']);
$params = array_slice($vars, 2);

// check the controller exists and load it
if (file_exists(DIR_CONTROL . $vars[1] . '.php')) {
    include_once(DIR_CONTROL . $vars[1] . '.php');
}

http_response_code($response->getHttpCode());
echo $response->buildResponse();
