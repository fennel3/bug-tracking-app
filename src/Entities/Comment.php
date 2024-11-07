<?php

namespace ITBugTracking\Entities;
class Comment
{
    public int $id;
    public string $name;
    public string $comment;
    public string $date_created;
    public int $issue_id;
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->issue_id,
            'name' => $this->name,
            'comment' => $this->comment
        ];
    }
}