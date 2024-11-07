<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Comment;
use PDO;

class CommentHydrator
{
    public static function getComments($db, $issue_id)
    {
        $query = $db->prepare('SELECT * FROM comments WHERE `issue_id` = :id;');
        $query->execute([
            'id' => $issue_id
        ]);
        $query->setFetchMode(PDO::FETCH_CLASS, Comment::class);

        $comments = $query->fetchAll();

        return $comments;
    }
}