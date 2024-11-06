<?php
require('./vendor/autoload.php');

use ITBugTracking\Entities\Issue;
use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

try {
    $db = DatabaseConnector::connect();
    if (isset($_GET['completed'])) {
        $completedFilter = $_GET['completed'];
    } else {
        $completedFilter = null;
    }

    $issues = IssueHydrator::getIssues($db, $completedFilter);

    echo json_encode(['issues' => $issues]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "message" => "Unexpected error"
    ]);
}

var_dump(Issue::getDate("today is 12th feb 2024"));
