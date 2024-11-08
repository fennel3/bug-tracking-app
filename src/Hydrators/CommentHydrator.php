<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Comment;
use PDO;

class CommentHydrator
{
    public static function getCommentsOnIssue($db, $issue)
    {
        $commentsQuery = $db->prepare("SELECT `id`, `name`, `comment`, `date_created` FROM `comments` WHERE issue_id = :id;");
        $commentsQuery->execute(['id' => $issue->id]);
        $commentsQuery->setFetchMode(PDO::FETCH_CLASS, Comment::class);
        return $commentsQuery->fetchAll();
    }

}