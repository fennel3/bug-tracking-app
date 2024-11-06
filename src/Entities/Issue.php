<?php

namespace ITBugTracking\Entities;

use JsonSerializable;

class Issue implements JsonSerializable
{
    public int $id;
    public string $title;
    public string|null $description;
    public string $severity;
    public string $date_created;
    public string $reporter;
    public int $department;
    public int $completed;
    public int|null $issue_id;
    public int|null $comment_count;
    public array|null $comments;

    public function jsonSerialize(): mixed
    {
        if (!isset($_GET['id'])) {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'summary' => substr($this->description, 0, 100),
                'severity' => $this->severity,
                'date_created' => $this->date_created,
                'comment_count' => $this->comment_count,
                'completed' => boolval($this->completed)
            ];
        } else {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'severity' => $this->severity,
                'date_created' => $this->date_created,
                'reporter' => $this->reporter,
                'department' => $this->department,
                'description' => $this->description,
                'comments' => $this->comments
            ];
        }

    }
}