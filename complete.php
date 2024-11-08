<?php
require 'vendor/autoload.php';

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

try {
    $db = DatabaseConnector::connect();
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $issueID = $_GET['id'];
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Missing issue id"]);
        return;
    }

    $issue = IssueHydrator::getIssue($db, $issueID);

    if (is_null($issue)) {
        http_response_code(400);
        echo json_encode(["message" => "Unknown issue id"]);
        return;
    }

    IssueHydrator::updateCompleted($db, $issueID);

    http_response_code(200);
    echo json_encode(["message" => "Issue " . $issueID . " has been completed"]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Unexpected error"]);
}