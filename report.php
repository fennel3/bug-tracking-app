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

$requiredExist = ValidationService::checkRequiredDataExists($data);
$validTitle = ValidationService::limitTitleCharLengthTo255($data['title']);
$validReporter = ValidationService::limitReporterCharLengthTo255($data['name']);
$validDescription = ValidationService::descriptionLimitCharLength($data['description']);
//$validSeverity = ValidationService::checkSeverityExists($data['severity']);
$checkSeverityIsInt = ValidationService::checkSeverityIsInt($data['severity']);
$checkDepartmentIsInt = ValidationService::checkDepartmentIsInt($data['department']);

$passedValidation = $requiredExist && $validTitle && $validReporter && $validDescription && $checkSeverityIsInt && $checkDepartmentIsInt;

if (!$passedValidation)
{
    http_response_code(400);
    echo json_encode(["message" => "Validation failed"]);
    return;
} else {

    $newIssue = IssueHydrator::createIssue($db, $data);

    if ($newIssue) {
        $output = [
            'message' => "Issue created",
            'id' => $newIssue['id']

        ];
        http_response_code(201);
    } else {
        $output = [
            'message' => "Unexpected error",
        ];
        http_response_code(500);
    }
    echo json_encode($output);


}











