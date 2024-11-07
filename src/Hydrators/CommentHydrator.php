<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Comment;
use PDO;

class CommentHydrator
{
    public static function getCommentsOnIssue($db, $issue)
    {
        $commentsQuery = $db->prepare("SELECT `name`, `comment`, DATE_FORMAT(`date_created`, '%d/%m/%Y %H:%i') AS 'date_created' FROM `comments` WHERE issue_id = :id;");
        $commentsQuery->execute(['id' => $issue->id]);
        $commentsQuery->setFetchMode(PDO::FETCH_CLASS, Comment::class);
        return $commentsQuery->fetchAll();
    }

}