<?php

$frontControllerPath = __DIR__ . '/public/index.php';
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestedResource = __DIR__ . '/public' . $requestUri;

if (file_exists($requestedResource) && is_file($requestedResource)) {
    return false;
}

require $frontControllerPath;