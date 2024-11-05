<?php
require('../vendor/autoload.php');
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

$db = DatabaseConnector::connect();
$report = IssueHydrator::getIssues($db);

echo json_encode($report);
