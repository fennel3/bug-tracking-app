<?php

namespace \Hydrators;

use PDO;

class IssueHydrator
{

    public static function createIssue($db, $issue)
    {
        //validate if fields are entered
        if (empty($issue['title']) || empty($issue['description']) || empty($issue['severity']) || empty(['reporter']) || empty($issue['department']) || empty($issue['completed'])) {
            throw new Exception('no data input');
            }
        //saniti"z"e 255 character limits

        if (strlen($issue['title'] || $issue['reporter']) < 0)
        {
            echo "Input is too short, minimum is 0 characters (255 max).";
        }
        elseif(strlen($issue['title'] || $issue['reporter']) > 255)
        {
            echo "Input is too long, maximum is 255 characters.";
        }

        //and 100000 description character limit
        if(strlen($issue['description']) > 10000)
        {
            echo "Input is too long, maximum is 10000 characters.";
        }


        $severityNumQuery = $db->prepare('SELECT `id` FROM `severities` WHERE `name` = :severity;');
        $severityNumQuery->execute([
            'severity' => $issue['severity']
        ]);

        $severityNum = $severityNumQuery->fetch();

        $query = $db->prepare('INSERT INTO `issues` (`title`, `description`, `severity`, `date_created`, `reporter`, `department`, `completed`) VALUES (:title, :description, :image, :severity, :date_created, :reporter, :department, :completed)');
        $query->execute([
            'name' => $issue['name'],
            'department' => $issue['department'],
            'title' => $issue['title'],
            'description' => $issue['description'],
            'severity' => $severityNum

        ]);
        return $db->lastInsertId();
    }
}
