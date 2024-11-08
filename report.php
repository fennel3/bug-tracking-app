<?php

require('./vendor/autoload.php');

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;
use ITBugTracking\Services\ValidationService;

$db = DatabaseConnector::connect();

$json = file_get_contents('php://input');

$data = json_decode($json, true);

try {
    $requiredExist = ValidationService::checkRequiredDataExists($data);

    if (!$requiredExist) {
        http_response_code(400);
        echo json_encode(["message" => "Invalid data"]);
        return;
    }

    $data['title'] = ValidationService::validateStringInput($data['title'], 100);

    $data['name'] = ValidationService::validateStringInput($data['name'], 255);

    if (isset($data['description'])) {
        $data['description'] = ValidationService::validateStringInput($data['description'], 65535);
    }

    $severityIsNumeric = is_numeric($data['severity']);
    if ($severityIsNumeric) {
        $data['severity'] = (int)$data['severity'];
        $severityExists = ValidationService::checkSeverityExists($db, $data['severity']);
    } else {
        $severityExists = false;
    }

    $departmentIsNumeric = is_numeric($data['department']);
    if ($departmentIsNumeric) {
        $data['department'] = (int)$data['department'];
        $departmentExists = ValidationService::checkDepartmentExists($db, $data['department']);
    } else {
        $departmentExists = false;
    }

    $passedValidation =
        $data['title']
        && $data['name']
        && $severityExists
        && $departmentExists;

    if (!$passedValidation) {
        http_response_code(400);
        echo json_encode(["message" => "Invalid issue data"]);
        return;
    }

    $newIssue = IssueHydrator::createIssue($db, $data);

    $output = [
        'message' => "Issue created",
        'id' => $newIssue['id']
    ];
    http_response_code(201);
    echo json_encode($output);

} catch (Exception $e) {
    $output = [
        'message' => "Unexpected error",
    ];
    http_response_code(500);
    echo json_encode($output);
}
