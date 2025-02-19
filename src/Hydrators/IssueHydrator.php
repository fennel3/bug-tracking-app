<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Comment;
use ITBugTracking\Entities\IssueDetails;
use PDO;
use ITBugTracking\Entities\Issue;

class IssueHydrator
{
    public static function getIssues(PDO $db, $completedFilter): array|null
    {
        $queryString = "SELECT `issues`.`id`,`issues`.`title`,LEFT(`issues`.`description`,100) AS 'summary', `issues`.`date_created`, COUNT(`comments`.`issue_id`) AS 'comment_count',`issues`.`completed`,`severities`.`name` AS 'severity'
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
    public static function getIssue($db, $issue_id)
    {
        $issueQuery = $db->prepare("SELECT `issues`.`id`,`issues`.`title`,`issues`.`description`, `issues`.`date_created`, `issues`.`reporter`,`issues`.`department`, `issues`.`completed`,`severities`.`name` AS 'severity'
                FROM `issues` 
                LEFT JOIN `severities` ON `issues`.`severity` = `severities`.`id`
                WHERE `issues`.`id` = :id");

        $issueQuery->execute([
            'id' => $issue_id
        ]);

        $issueQuery->setFetchMode(PDO::FETCH_CLASS, IssueDetails::class);

        $issue = $issueQuery->fetch();

        if (!$issue) {
            return null;
        }

        $comments = CommentHydrator::getCommentsOnIssue($db, $issue);
        $issue->comment_count = count($comments);
        $issue->comments = $comments;

        return $issue;

    }

    public static function createIssue($db, $data): array
    {

        $createQuery = $db->prepare('INSERT INTO `issues`  (`reporter`, `department`, `title`, `description`, `severity`, `date_created`) VALUES (:reporter, :department, :title, :description, :severity, current_timestamp)');
        $createQuery->execute([
            'reporter' => $data['name'],
            'department' => $data['department'],
            'title' => $data['title'],
            'description' => $data['description'],
            'severity' => $data['severity'],
        ]);

        $id = $db->lastInsertId();

        return ['success' => true, 'id' => $id];
    }

    public static function getDepartmentIds(PDO $db): array
    {
        $queryString = "SELECT `department` FROM `issues` GROUP BY `department`; ";

        $query = $db->prepare($queryString);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        return $query->fetchAll();
    }

    public static function updateCompleted(PDO $db, $issue_id): bool
    {
        $queryUpdate = $db->prepare('UPDATE `issues` SET `completed` = 1 WHERE `id` = :id;');
        $queryUpdate->execute([
            'id' => $issue_id
        ]);
        return true;
    }
}