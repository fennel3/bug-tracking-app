<?php

namespace ITBugTracking\Entities;

use ITBugTracking\Entities\Issue;
use ITBugTracking\Services\DateFormatter;

class IssueDetails extends Issue
{
    public array $comments;
    public string $reporter;
    public int $department;
    public string|null $description;

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'severity' => $this->severity,
            'date_created' => $this->formatDate(),
            'comment_count' => $this->comment_count,
            'reporter' => $this->reporter,
            'department' => $this->department,
            'description' => $this->description,
            'comments' => $this->comments
        ];
    }

}