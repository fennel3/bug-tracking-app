<?php

namespace ITBugTracking\Entities;

class Issue
{
    public int $id;
    public string $title;
    public string $description;
    public int $severity;
    public string $date_created;

    public string $reporter;

    public int $department;

    public int $completed;
}