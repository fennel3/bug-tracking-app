<?php

namespace ITBugTracking\Services;

class DateFormatter
{
    public static function getDate($date_created): string
    {
        $date = new \DateTime($date_created);
        return $date->format("d/m/Y");

    }
}