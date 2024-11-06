<?php
namespace ITBugTracking\Services;

class ValidationService
{
    public static function createIssue($db, $issue)
    {
        //validate if fields are entered
        if (empty($issue['name']) ||empty($issue['title']) || empty($issue['description']) || empty($issue['severity']) || empty($issue['department']) ) {
            throw new Exception('no data input');
        }
        //saniti"z"e 255 character limits
        $issue['name'] = htmlspecialchars(($issue['name']));
        $issue['department'] = is_int(($issue['department']));
        $issue['title'] = htmlspecialchars(($issue['title']));
        $issue['description'] = htmlspecialchars(($issue['description']));
        $issue['severity'] = is_int(($issue['severity']));

        if (strlen(($issue['name'] || $issue['title'])) < 0) {
            echo "Input is too short, minimum is 0 characters (255 max).";
        } elseif (strlen($issue['name'] || $issue['title']) > 255) {
            echo "Input is too long, maximum is 255 characters.";
        }

        //and 100000 description character limit
        if (strlen($issue['description']) > 10000) {
            echo "Input is too long, maximum is 10000 characters.";
        }

        $severityNumQuery = $db->prepare('SELECT `id` FROM `severities` WHERE `name` = :severity;');
        $severityNumQuery->execute([
            'severity' => $issue['severity']
        ]);

        $severityNum = $severityNumQuery->fetch();

        $query = $db->prepare('INSERT INTO `comments` (`name`) VALUES (:name); INSERT INTO `issues` (`department`, `title`, `description`, `severity`) VALUES (:department, :title, :description, :image, :severity)');
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