<?php

namespace ITBugTracking\Entities;

use ITBugTracking\Services\DateFormatter;
use JsonSerializable;

class Issue implements JsonSerializable
{
    public int $id;
    public string $title;
    public string|null $summary;
    public string $severity;
    public string $date_created;
    public int $completed;
    public int $comment_count;

    public function getCompleted(): bool
    {
        return $this->completed == 1;
    }

    public static function formatDate($date_created) {
        $date = new \DateTime($date_created);
        return $date->format("d/m/Y");
    }

    public function jsonSerialize(): mixed
    {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'summary' => $this->summary,
                'severity' => $this->severity,
                'date_created' => $this->formatDate($this->date_created),
                'comment_count' => $this->comment_count,
                'completed' => $this->getCompleted()
            ];
    }
}