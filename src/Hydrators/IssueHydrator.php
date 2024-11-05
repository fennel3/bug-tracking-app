<?php

namespace ITBugTracking\Hydrators;


use PDO;
use ITBugTracking\Entities\IssueEntity;

class IssueHydrator
{
    public static function getIssues(PDO $db, $completedFilter)
    {
        $queryString = 'SELECT `issues`.`id`, `issues`.`title`, `issues`.`description`, `issues`.`date_created`, `issues`.`reporter`, `issues`.`completed`, `severities`.`name` AS `severity` FROM `severities` LEFT JOIN `issues` ON `issues`.`severity` = `severities`.`id`';

        if ($completedFilter != null) {
            if ($completedFilter === '0' ) {
                $queryString .= ' WHERE `completed` = \'0\'';
            } else {
                $queryString .= ' WHERE `completed` = \'1\'';
            }
        }

        $query = $db->prepare($queryString);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, IssueEntity::class);
        return $query->fetchAll();
    }

}
