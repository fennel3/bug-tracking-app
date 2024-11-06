<?php

require('./vendor/autoload.php');

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

$db = DatabaseConnector::connect();

$json = file_get_contents('php://input');

$data = json_decode($json, true);

$newIssue = IssueHydrator::createIssue($data);

header('Content-Type: application/json; charset=utf-8');

if ($newIssue) {
    $output = [
        'success' => true,
        'message' => 'Success!',
    ];
    http_response_code(201);
} else {
    $output = [
        'success' => false
    ];
    http_response_code(500);
}
echo json_encode($output);









