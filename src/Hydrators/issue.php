<?php


namespace \Hydrators;

use PDO;

class IssueHydrator
{
    public static function getIssues(PDO $db)
    {
        $query = $db->prepare('SELECT `issues`.`id`, 
            `issues`.`title`,
            `issues`.`description`, 
            `issues`.`date_created`, 
            `issues`.`reporter`, 
            `issues`.`department`,
            `issues`.`completed`, 
            `severities`.`name` AS `severity`
            FROM `severities`
            LEFT JOIN `issues` 
            ON `issues`.`severity` = `severities`.`id`');
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, Issues::class);
        return $query->fetchAll();
    }

}
