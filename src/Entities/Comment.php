<?php

namespace ITBugTracking\Entities;
use DateTime;
use JsonSerializable;

class Comment implements JsonSerializable
{
    public int $id;
    public string $name;
    public string $comment;
    public string $date_created;

    public function formatCommentDate(): string {
        $date = new DateTime($this->date_created);
        return $date->format("d/m/Y H:i");
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'comment' => $this->comment,
            'date_created' => $this->formatCommentDate(),
        ];
    }
}