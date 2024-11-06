<?php

namespace ITBugTracking\Hydrators;

use ITBugTracking\Entities\Comment;
use PDO;

class CommentHydrator
{
    public static function getCommentCount($db, $id)
    {
        $commentCountQuery = $db->prepare("SELECT COUNT(issue_id) AS 'comment_count' FROM `comments` WHERE `issue_id` = :id");
        $commentCountQuery->bindvalue(':id', $id, PDO::PARAM_INT);
        $commentCountQuery->execute();
        return $commentCountQuery->fetch();
    }

    public static function getComments(PDO $db, $id){
        $commentsQuery = $db->
    }
}