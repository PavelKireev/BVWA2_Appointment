<?php

// Enable error reporting for debugging (disable this in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Respond to preflight request
    header('Access-Control-Allow-Origin: http://localhost:4200');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    exit(0);
}

// Set CORS headers for actual requests
header('Access-Control-Allow-Origin: http://localhost:4200');

// Autoload classes using Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Database connection settings
$dbHost = 'localhost';
$dbName = 'appointment_db';
$dbUser = '';
$dbPass = '';

try {
    // Create a PDO instance as a database connection
    $pdo = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Define the base path of the appointments API endpoint
$basePath = '/appointments/available';

// Parse the URL path
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check if the request is for the appointments API
if (str_starts_with($urlPath, $basePath) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $doctorUuid = $_GET['doctorUuid'] ?? null;

    if ($doctorUuid) {
        $appointmentController = new Src\controller\AppointmentController($pdo);
        $availableTimes = $appointmentController->getAvailableAppointmentTimes($doctorUuid);

        header('Content-Type: application/json');
        echo json_encode($availableTimes);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Bad Request: Missing doctorUuid']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Page not found']);
}
