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

    public static function createComment($db, $data, $issue_id): array
    {

        $createQuery = $db->prepare('INSERT INTO `comments`  (`name`, `comment`, `date_created`, `issue_id`) VALUES (:name, :comment, current_timestamp, :issue_id);');
        $createQuery->execute([
            'name' => $data['name'],
            'comment' => $data['comment'],
            'issue_id' => $issue_id
        ]);

        $id = $db->lastInsertId();

        return ['success' => true, 'id' => $id];
    }
}