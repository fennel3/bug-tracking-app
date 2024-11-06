<?php
namespace ITBugTracking\Services;

class ValidationService
{
    public static function createIssue($db, $issue)
    {

        //validate if fields are entered
        if (empty($issue['name']) ||empty($issue['title']) || empty($issue['severity']) || empty($issue['department']) ) {
            http_response_code(400 );
            echo '"message": "Invalid issue data"';

        }
        //sanitiize 255 character limits
        $issue['name'] = htmlspecialchars(($issue['name']));
        $issue['title'] = htmlspecialchars(($issue['title']));

        if (strlen($issue['name'] || $issue['title']) > 255) {
            http_response_code(400 );
            echo '"message": "Invalid issue data"';
        }

        //and check if description exists, set to null or 100000 character limit
        if (empty($issue['description'])) {
            $issue['description'] = null;
        } else{
            if (strlen($issue['description']) > 10000) {
                http_response_code(400 );
                echo '"message": "Invalid issue data"';
            }
        }

        //check severity and department are integers
            if(!filter_var($issue['severity'],FILTER_VALIDATE_INT)) {
                http_response_code(400 );
                echo '"message": "Invalid issue data"';
            }
            if(!filter_var($issue['department'],FILTER_VALIDATE_INT)){
                http_response_code(400 );
                echo '"message": "Invalid issue data"';
            }
//
//        // Fetch severity ID if severity is provided as a name
//        $severityNumQuery = $db->prepare('SELECT `id` FROM `severities` WHERE `name` = :severity;');
//        $severityNumQuery->execute([
//            'severity' => $issue['severity']
//        ]);
//
//        $severityNum = $severityNumQuery->fetch();
//
//        $query = $db->prepare('INSERT INTO `comments` (`name`) VALUES (:name); INSERT INTO `issues` (`department`, `title`, `description`, `severity`) VALUES (:department, :title, :description, :image, :severity)');
//        $query->execute([
//            'name' => $issue['name'],
//            'department' => $issue['department'],
//            'title' => $issue['title'],
//            'description' => $issue['description'],
//            'severity' => $severityNum
//        ]);
        echo http_response_code(201);
        return $db->lastInsertId();
            }
}
