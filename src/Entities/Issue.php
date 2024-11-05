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
    public int $completed;
    public int|null $comment_count;

    public function getCompleted($completed): bool
    {
        return $completed == 1;
    }

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