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
    public int|null $issue_id;
    public int|null $comment_count;

    public function jsonSerialize(): mixed
    {

        if (!is_null($this->description)) {
            $summary = substr($this->description, 0, 100);
        } else {
            $summary = null;
        }



        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $summary,
            'severity' => $this->severity,
            'date_created' => $this->date_created,
            'comment_count' => $this->comment_count,
            'completed' => boolval($this->completed)
        ];
    }
}