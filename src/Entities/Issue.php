<?php

namespace ITBugTracking\Entities;

use JsonSerializable;

class Issue implements JsonSerializable
{
    public int $id;
    public string $title;
    public string $description;
    public string $severity;
    public string $date_created;

    public string $reporter;

    public int $department;

    public int $completed;
    public int $comment_count;

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => substr($this->description, 0, 100),
            'severity' => $this->severity,
            'date_created' => $this->date_created,
            'comment_count' => $this->comment_count,
            'completed' => boolval($this->completed)
        ];
    }
}

