<?php

require('./vendor/autoload.php');

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

$db = DatabaseConnector::connect();

$json = file_get_contents('php://input');

$data = json_decode($json, true);


var_dump($json);









