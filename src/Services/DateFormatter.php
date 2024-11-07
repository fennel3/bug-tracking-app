<?php

namespace ITBugTracking\Services;

class DateFormatter
{
    public static function formatIssueDate($date_created): string
    {
        $date = new \DateTime($date_created);
        return $date->format("d/m/Y");

    }

    public static function formatCommentDate($date_created) :string
    {
        $date = new \DateTime($date_created);
        return $date->format("d/m/Y H:i");
    }
}