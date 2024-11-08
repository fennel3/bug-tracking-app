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

    public static function limitTitleCharacterLength($data): string
    {
        return substr($data, 0, 255);
    }

    public static function limitReporterCharacterLength($data): string
    {
        return substr($data, 0, 255);
    }

    public static function limitDescriptionCharacterLength($data): string
    {
        return substr($data, 0, 10000);
    }

    public static function checkIsInt(int|string $input): int|false
    {
        if (is_numeric($input)) {
            return intval($input);
        } else {
            return false;
        }
    }

    public static function checkDepartmentIsInt(int|string $department): int|false
    {
        return filter_var($department, FILTER_VALIDATE_INT);
    }
}
