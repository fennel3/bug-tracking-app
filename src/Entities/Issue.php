<?php

namespace ITBugTracking\Entities;

use JsonSerializable;

class Issue implements JsonSerializable
{
    public int $id;
    public string $title;
    public string|null $summary;
    public string $severity;
    public string $date_created;
    public int $completed;
    public int|null $comment_count;

    public function getCompleted($completed): bool
    {
        return $completed == 1;
    }

    public static function getDate($date_created): string
    {
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
            'date_created' => self::getDate($this->date_created),
            'comment_count' => $this->comment_count,
            'completed' => boolval($this->completed)
        ];
    }
}