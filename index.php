<?php

use ITBugTracking\Factories\DatabaseConnector;

require('./vendor/autoload.php');

$db = DatabaseConnector::connect();

