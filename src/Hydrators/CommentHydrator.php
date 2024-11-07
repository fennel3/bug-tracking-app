<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Comment;
use PDO;

class CommentHydrator
{
    public static function getCommentsOnIssue($db, $issue_id)
    {
        $query = $db->prepare("SELECT `name`, `comment`, DATE_FORMAT(`date_created`, '%d/%m/%Y %H:%i') AS 'date_created' FROM `comments` WHERE issue_id = :id;");
        $query->execute(['id' => $issue_id]);
        $query->setFetchMode(PDO::FETCH_CLASS, Comment::class);
        $comments = $query->fetchAll();
        return $comments;
    }
}