<?php

namespace ITBugTracking\Hydrators;

use PDO;
use ITBugTracking\Entities\Issue;

class IssueHydrator
{
    public static function getIssues(PDO $db, $completedFilter)
    {
        $queryString = 'SELECT `issues`.`id`, `issues`.`title`, `issues`.`description`, `issues`.`date_created`, `issues`.`reporter`, `issues`.`completed`, `issues`.`department`, `severities`.`name` AS `severity` FROM `issues` LEFT JOIN `severities` ON `issues`.`severity` = `severities`.`id`';

        if (is_null($completedFilter)) {
            if ($completedFilter == 0 ) {
                $queryString .= ' WHERE `issues`.`completed` = 0;';
            } elseif ($completedFilter == 1) {
                $queryString .= ' WHERE `issues`.`completed` = 1;';
            }
        } else {
            $queryString .= ';';
        }

        $query = $db->prepare($queryString);
        $result = $query->execute();
        if ($result) {
            $query->setFetchMode(PDO::FETCH_CLASS, Issue::class);
            return $query->fetchAll();
        } else {
            return null;
        }
    }
    public static function getIssue($db, $issue_id)
    {
        $issueQuery = $db->prepare("SELECT * FROM `issues` WHERE `id` = :id");
        $issueQuery->bindvalue(':id', $issue_id, PDO::PARAM_INT);
        $issueQuery->execute();
        $issueQuery->setFetchMode(PDO::FETCH_CLASS, Issue::class);
        return $issueQuery->fetchall();
    }
}
