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
    public string $reporter;
    public int $department;
    public int $completed;
    public int|null $issue_id;
    public int|null $comment_count;
    public array|null $comments;

    public function getCompleted($completed): bool
    {
        return $completed == 1;
    }

    public function jsonSerialize(): mixed
    {
        if (!isset($_GET['id'])) {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'summary' => $this->summary,
                'severity' => $this->severity,
                'date_created' => DateFormatter::getDate($this->date_created),
                'comment_count' => $this->comment_count,
                'completed' => boolval($this->completed)
            ];
        } else {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'severity' => $this->severity,
                'date_created' => DateFormatter::getDate($this->date_created),
                'reporter' => $this->reporter,
                'department' => $this->department,
                'description' => $this->summary,
                'comments' => $this->comments
            ];
        }

    }
}