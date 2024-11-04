<?php


namespace \Hydrators;

use PDO;

class IssueHydrator
{
    public static function getIssues(PDO $db, $completedFilter)
    {
        $queryString = "
            SELECT `issues`.`id`, 
            `issues`.`title`, 
            `issues`.`description`, 
            `issues`.`date_created`, 
            `issues`.`reporter`, 
            `issues`.`department`,
            `issues`.`completed`, 
            `severities`.`name` AS `severity` 
            FROM `severities` 
            LEFT JOIN `issues` 
            ON `issues`.`severity` = `severities`.`id`";

        if ($completedFilter != null) {
            if ($completedFilter === '0' ) {
                return $queryString .= " WHERE `completed` = '0'";
            } else {
                return $queryString .= " WHERE `completed` = '1'";
            }
        }

        $query = $db->prepare($queryString);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, Issues::class);
        return $query->fetchAll();
    }

}
