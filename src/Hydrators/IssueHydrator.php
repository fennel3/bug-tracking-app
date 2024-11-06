<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Comment;
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
        $issueQuery = $db->prepare("SELECT `issues`.`id`,`issues`.`title`,`issues`.`description`,`issues`.`date_created`,`issues`.`reporter`,`issues`.`department`,`comments`.`issue_id`, `issues`.`completed`,`severities`.`name` AS `severity`
                FROM `issues` 
                LEFT JOIN `severities` ON `issues`.`severity` = `severities`.`id`
                LEFT JOIN `comments` ON `issues`.`id` = `comments`.`issue_id`
                WHERE `issues`.`id` = :id");
        $issueQuery->execute([
            'id' => $issue_id
        ]);
        $issueQuery->setFetchMode(PDO::FETCH_CLASS, Issue::class);
        $issue = $issueQuery->fetch();

        $commentsQuery = $db->prepare("SELECT `name`, `comment`, `date_created` AS 'comment_created' FROM `comments` WHERE issue_id = :id;");
        $commentsQuery->execute(['id' => $issue->issue_id]);
        $commentsQuery->setFetchMode(PDO::FETCH_CLASS, Comment::class);
        $comments = $commentsQuery->fetchAll();

        $returnedComments = [];


        foreach($comments as $comment) {
            $returnedComments[] = ['name' => $comment->name, 'comment' => $comment->comment, 'date_created' => $comment->comment_created];
        }

        $issue->comments = $returnedComments;

        return $issue;

    }
}
