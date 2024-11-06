<?php

namespace ITBugTracking\Hydrators;

use PDO;
use ITBugTracking\Entities\Issue;

class IssueHydrator
{
    public static function getIssues(PDO $db, $completedFilter): array|null
    {
        $queryString = 'SELECT `issues`.`id`,`issues`.`title`,`issues`.`description`,`issues`.`date_created`,`comments`.`issue_id`,COUNT(`comments`.`issue_id`) AS `comment_count`,`issues`.`completed`,`severities`.`name` AS `severity`
                FROM `issues`
                LEFT JOIN `severities` ON `issues`.`severity` = `severities`.`id`
                LEFT JOIN `comments` ON `issues`.`id` = `comments`.`issue_id`';

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

    public static function createIssue($db){

       // $date = date('Y-m-d H:i:s', time());

        $createQuery = $db->prepare('INSERT INTO `issues`  (`reporter`, `department`, `title`, `description`, `severity`, `date_created`) VALUES (:reporter, :department, :title, :description, :severity, current_timestamp)') ;
        $createQuery->execute([
            'reporter' => $db->quote($_POST['name']),
            'department' => $db->quote($_POST['department']),
            'title' => $db->quote($_POST['title']),
            'description' => $db->quote($_POST['description']),
            'severity' => $db->quote($_POST['severity']),
        ]);
        return true;
    }
}
