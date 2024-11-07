<?php

namespace ITBugTracking\Hydrators;

use PDO;

class SeverityHydrator
{
    public static function getSeverityIds(PDO $db): array
    {
        $queryString = "SELECT `id` FROM `severities`;";

        $query = $db->prepare($queryString);
        $query->execute();
        return $query->fetchAll();
    }
}