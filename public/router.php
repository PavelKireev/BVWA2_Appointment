<?php

// Check if the requested file exists
if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    // Serve the requested file
    return false;
}

// Otherwise, route all requests through index.php
require __DIR__ . '/index.php';