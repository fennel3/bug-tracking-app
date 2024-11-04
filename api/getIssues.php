<?php
require('../vendor/autoload.php');

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

$db = DatabaseConnector::connect();
$completedFilter = $_GET['completed'];
$issues = IssueHydrator::getIssues($db, $completedFilter);

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
echo json_encode($issues);