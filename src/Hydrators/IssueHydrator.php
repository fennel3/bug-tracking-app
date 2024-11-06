<?php

namespace ITBugTracking\Hydrators;

use PDO;
use ITBugTracking\Entities\Issue;

class IssueHydrator
{
    public static function getIssues(PDO $db, $completedFilter): array|null
    {
        $queryString = "SELECT `issues`.`id`,`issues`.`title`,LEFT(`issues`.`description`,100) AS 'summary',`issues`.`date_created`,`issues`.`reporter`,`issues`.`department`,COUNT(`comments`.`issue_id`) AS `comment_count`,`issues`.`completed`,`severities`.`name` AS `severity`
                FROM `issues`
                LEFT JOIN `severities` ON `issues`.`severity` = `severities`.`id`
                LEFT JOIN `comments` ON `issues`.`id` = `comments`.`issue_id`";

        if (is_null($completedFilter)) {
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
}
