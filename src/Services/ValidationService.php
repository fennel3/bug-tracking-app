<?php

namespace ITBugTracking\Services;

use ITBugTracking\Hydrators\SeverityHydrator;
use PDO;

class ValidationService
{

    public static function checkRequiredDataExists($data): bool
    {
        return !empty($data['reporter']) && !empty($data['title']) && !empty($data['severity']) && !empty($data['department']);
    }

    public static function limitStringLength(string $string, int $limit) {
        $output = trim($string);
        return substr($output, 0, $limit);
    }

    public static function checkIsInt(int|string $input): int|false
    {
        if (is_numeric($input)) {
            return intval($input);
        } else {
            return false;
        }
    }
}
