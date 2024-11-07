<?php

namespace ITBugTracking\Services;

class DateFormatter
{
    public static function getDateCreated($date_created) {
        $date = new \DateTime($date_created);
        return $date->format("d/m/Y");
    }
}