<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Issue;
use PDO;

class IssueHydrator
{
    public static function getIssue($db, $issue_id)
    {
        $issueQuery = $db->prepare("SELECT * FROM `issues` WHERE `id` = :id");
        $issueQuery->bindvalue(':id', $issue_id, PDO::PARAM_INT);
        $issueQuery->execute();
        $issueQuery->setFetchMode(PDO::FETCH_CLASS, Issue::class);
        return $issueQuery->fetchall();
    }
}

