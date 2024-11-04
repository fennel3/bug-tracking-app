<?php

use ITBugTracking\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

require('./vendor/autoload.php');

$db = DatabaseConnector::connect();


$test = IssueHydrator::getIssue($db, 4);


echo "<pre>";
var_dump($test);
