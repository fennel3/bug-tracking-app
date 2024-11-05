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

    public bool $completed;
    public int $count;

    public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
        $output = [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->description,
            'severity' => $this->severity,
            'date_created' => $this->date_created,
            'comment_count' => $this->count,
            'completed' => $this->completed
        ];

        return $output;
    }

}

