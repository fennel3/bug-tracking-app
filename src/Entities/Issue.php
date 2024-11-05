<?php

namespace ITBugTracking\Entities;

class Issue
{
    public int  $id;
    public string $title;
    public string | null $description;
    public string $date_created;
    public string $reporter;
    public int $completed;
    public int $department;
    public string $severity;

}