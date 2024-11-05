<?php
require 'vendor/autoload.php';

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;


header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

try {
    $db = DatabaseConnector::connect();
    $issue = IssueHydrator::getIssue($db, $_GET['id']);

    echo json_encode($issue);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Unexpected error", "error" => print($e)]);
}