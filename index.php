<?php

use ITBugTracking\DatabaseConnector;
use ITBugTracking\Hydrators\CommentHydrator;
use ITBugTracking\Hydrators\IssueHydrator;

require('./vendor/autoload.php');

$db = DatabaseConnector::connect();


$test = CommentHydrator::getCommentCount($db, 73);

echo "<pre>";
var_dump($test);