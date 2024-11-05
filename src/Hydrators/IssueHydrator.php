<?php

namespace ITBugTracking\Hydrators;

use PDO;
use ITBugTracking\Entities\Issue;

class IssueHydrator
{
    public static function getIssues(PDO $db, $completedFilter): array|null
    {
        $queryString = 'SELECT `issues`.`id`,`issues`.`title`,`issues`.`description`,`issues`.`date_created`,`issues`.`reporter`,`issues`.`department`,`comments`.`issue_id`,COUNT(`comments`.`issue_id`) AS `comment_count`,`issues`.`completed`,`severities`.`name` AS `severity`
                FROM `issues`
                LEFT JOIN `severities` ON `issues`.`severity` = `severities`.`id`
                LEFT JOIN `comments` ON `issues`.`id` = `comments`.`issue_id`';

        if (!isset($completedFilter)) {
            $queryString .= ' WHERE `issues`.`completed` = 0';
        }

        $queryString .= ' GROUP BY
                `issues`.`id`, `issues`.`title`, `issues`.`description`, `issues`.`date_created`,
                `issues`.`reporter`, `issues`.`department`, `issues`.`completed`, `severities`.`name`;';

        $query = $db->prepare($queryString);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, Issue::class);
        return $query->fetchAll();
    }
    public static function getIssue($db, $issue_id)
    {
        $issueQuery = $db->prepare("SELECT `issues`.`id`,`issues`.`title`,`issues`.`description`,`issues`.`date_created`,`issues`.`reporter`,`issues`.`department`,`comments`.`issue_id`,COUNT(`comments`.`issue_id`) AS `comment_count`,`issues`.`completed`,`severities`.`name` AS `severity`
                FROM `issues` 
                LEFT JOIN `severities` ON `issues`.`severity` = `severities`.`id`
                LEFT JOIN `comments` ON `issues`.`id` = `comments`.`issue_id`
                WHERE `issues`.`id` = :id");
        $issueQuery->execute([
            'id' => $issue_id
        ]);
        $issueQuery->setFetchMode(PDO::FETCH_CLASS, Issue::class);
        return $issueQuery->fetch();
    }
}
