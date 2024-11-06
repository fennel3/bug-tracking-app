<?php

namespace \Hydrators;

use PDO;

class IssueHydrator
{
    public static function createIssue($db, $issue)
    {
        $severityNumQuery = $db->prepare('SELECT `id` FROM `severities` WHERE `name` = :severity;');
        $severityNumQuery->execute([
            'severity' => $issue['severity']
        ]);
        $severityNum = $severityNumQuery->fetch();

        $query = $db->prepare('INSERT INTO `issues` (`title`, `description`, `severity`, `date_created`, `reporter`, `department`, `completed`) VALUES (:title, :description, :image, :severity, :date_created, :reporter, :department, :completed)');
        $query->execute([
            'title' => $issue['title'],
            'description' => $issue['description'],
            'severity' => $severityNum,
            'date_created' => $issue['date_created'],
            'reporter' => $issue['reporter'],
            'department' => $issue['department'],
            'completed' => $issue['completed']
        ]);
        return $db->lastInsertId();
    }

}