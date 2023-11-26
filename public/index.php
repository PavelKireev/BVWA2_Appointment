<?php

// Enable error reporting for debugging (disable this in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload classes using Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Database connection settings
$dbHost = 'localhost';
$dbName = 'appointment_db';
$dbUser = '';
$dbPass = '';

try {
    // Create a PDO instance as a database connection
    $pdo = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($urlPath == '/appointments/available' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $doctorUuid = $_GET['doctorUuid'] ?? null;

    if ($doctorUuid) {
        $appointmentController = new Src\controller\AppointmentController($pdo);
        $availableTimes = $appointmentController->getAvailableAppointmentTimes($doctorUuid);

        header('Content-Type: application/json');
        echo json_encode($availableTimes);
    } else {
        // Handle the case where doctorUuid is not provided
        http_response_code(400);
        echo "Bad Request: Missing doctorUuid";
    }
} else {
    // Default response for unmatched routes
    http_response_code(404);
    echo "Page not found";
}
