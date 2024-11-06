<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Comment;
use ITBugTracking\Entities\IssueDetails;
use ITBugTracking\Services\DateFormatter;
use PDO;
use ITBugTracking\Entities\Issue;

class IssueHydrator
{
    public static function getIssues(PDO $db, $completedFilter): array|null
    {
        $queryString = "SELECT `issues`.`id`,`issues`.`title`,LEFT(`issues`.`description`,100) AS 'summary',`issues`.`date_created`,COUNT(`comments`.`issue_id`) AS `comment_count`,`issues`.`completed`,`severities`.`name` AS `severity`
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
        $issueQuery = $db->prepare("SELECT `issues`.`id`,`issues`.`title`,`issues`.`description` AS 'summary',`issues`.`date_created`, `issues`.`reporter`,`issues`.`department`, `issues`.`completed`,`severities`.`name` AS `severity`
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

        $commentsQuery = $db->prepare("SELECT `name`, `comment`, `date_created` FROM `comments` WHERE issue_id = :id;");
        $commentsQuery->execute(['id' => $issue->id]);
        $commentsQuery->setFetchMode(PDO::FETCH_CLASS, Comment::class);
        $comments = $commentsQuery->fetchAll();

        $issue->comment_count = count($comments);

        $returnedComments = [];


        foreach($comments as $comment) {
            $returnedComments[] = ['name' => $comment->name, 'comment' => $comment->comment, 'date_created' => DateFormatter::getDate($comment->comment_created)];
        }

        $issue->comments = $returnedComments;

        return $issue;

    }
}
