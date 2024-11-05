<?php
require('./vendor/autoload.php');

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

$db = DatabaseConnector::connect();

if (isset($_GET['completed'])) {
    $completedFilter = $_GET['completed'];
}

$issues = IssueHydrator::getIssues($db, $completedFilter);

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

if (!is_null($issues)) {
    echo json_encode(['issues' => $issues]);
} else {
    http_response_code(500);
    echo json_encode([
        "message" => "Unexpected error"
    ]);
}
