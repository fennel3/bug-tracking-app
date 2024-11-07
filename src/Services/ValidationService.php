<?php

namespace ITBugTracking\Services;

use ITBugTracking\Hydrators\SeverityHydrator;
use PDO;

class ValidationService
{

    public static function checkRequiredDataExists($data): bool
    {
        return !empty($data['reporter']) || !empty($data['title']) || !empty($data['severity']) || !empty($data['department']);
    }

    public static function limitTitleCharLengthTo255($data)
    {
        if (isset($data)) {

            if (strlen($data) > 255) {
                $data = substr($data, 0, 255);
            }
            return $data;
        }
    }

    public static function limitReporterCharLengthTo255($data)
    {
        if (strlen($data) > 255) {
            $data = substr($data, 0, 255);
        }
        return $data;

    }

    public static function descriptionLimitCharLength($data)
    {
        if (strlen($data) > 10000) {
            $data = substr($data, 0, 10000);
        }
        return $data;
    }

//    public static function checkSeverityExists(int | string $severity): bool {
//        $severities = SeverityHydrator::getSeverityIds();
//        return in_array($severity, $severities);
//
//    }

    public static function checkSeverityIsInt(int|string $severity): int|false
    {
        if (is_numeric($severity)) {
            return intval($severity);
        } else {
            return false;
        }

    }

    public static function checkDepartmentIsInt(int|string $department): int|false
    {
        return filter_var($department, FILTER_VALIDATE_INT);
    }
}
