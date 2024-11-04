<?php
require('../vendor/autoload.php');

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

$db = DatabaseConnector::connect();
$issues = IssueHydrator::getIssues($db);

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
echo json_encode($issues);

git commit -m"moved issues.php to /api"
