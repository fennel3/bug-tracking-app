<?php

namespace ITBugTracking\Entities;

use ITBugTracking\Entities\Issue;

class IssueDetails extends Issue
{
    public array|null $comments;
    public string $reporter;
    public int $department;
    public string $description;

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'severity' => $this->severity,
            'date_created' => $this->date_created,
            'comment_count' => $this->comment_count,
            'reporter' => $this->reporter,
            'department' => $this->department,
            'description' => $this->summary,
            'comments' => $this->comments
        ];
    }

}