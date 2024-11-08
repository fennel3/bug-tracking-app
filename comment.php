<?php

require('./vendor/autoload.php');

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\CommentHydrator;
use ITBugTracking\Services\ValidationService;

$db = DatabaseConnector::connect();

if (isset($_GET['id'])) {
    $issue_id = $_GET['id'];
} else {
    http_response_code(400);
    echo json_encode(["message" => "Invalid comment data"]);
    return;
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

try {
    $newIssue = CommentHydrator::createComment($db, $data, $issue_id);

    header('Content-Type: application/json; charset=utf-8');
    header("Access-Control-Allow-Origin: *");

    $data['name'] = ValidationService::validateStringInput($data['name'], 255);

    $data['comment'] = ValidationService::validateStringInput($data['comment'], 65535);

    $passedValidation =
        $data['name'] != '' && $data['name']
        && $data['comment'] != '' && $data['comment'];

    if (!$passedValidation) {
        http_response_code(400);
        echo json_encode(["message" => "Invalid comment data"]);
        return;
    }

    if ($newIssue) {
        $output = [
            'message' => "Issue created",
            'id' => $newIssue['id']
        ];
        http_response_code(201);
        echo json_encode($output);
    }
} catch (Exception $e) {
    $output = [
        'message' => "Unexpected error",
    ];
    http_response_code(500);
    echo json_encode($output);
}
