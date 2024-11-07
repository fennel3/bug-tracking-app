<?php

namespace ITBugTracking\Services;

class DateFormatter
{
    public static function formatDate($date_created) {
        $date = new \DateTime($date_created);
        return $date->format("d/m/Y");
    }
}