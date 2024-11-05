<?php
require 'vendor/autoload.php';

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

$db = DatabaseConnector::connect();
$issue = IssueHydrator::getIssue($db, $_GET['id']);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($issue);