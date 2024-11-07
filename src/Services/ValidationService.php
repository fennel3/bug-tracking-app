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
    

    //sanitize 255 character limits
    public static function limitTitleCharLengthTo255($data)
    {
        if (strlen($data['title']) > 255) {
            $data['title'] = substr($data['title'], 0, 255);
        }
        return $data['title'];
    }

    public static function limitReporterCharLengthTo255($data)
    {
        if (strlen($data['reporter']) > 255) {
            $data['reporter'] = substr($data['reporter'], 0, 255);
        }
        return $data['reporter'];
    }

    // 100000 character limit for description
    public static function descriptionLimitCharLength($data) {
        if (strlen($data['description']) > 10000) {
            $data['description'] = substr($data['description'], 0, 10000);
        }
            return $data;
    }

    public static function checkSeverityExists(PDO $db, int | string $severity): bool {
        $severities = SeverityHydrator::getSeverityIds($db);
        return in_array($severity, $severities);

    }
//        check severity and department are integers

    public static function checkSeverityIsInt(int | string $severity): int | false {
        return filter_var($severity, FILTER_VALIDATE_INT);
        }

    public static function checkDepartmentIsInt(int | string $department): int | false {
        return filter_var($department, FILTER_VALIDATE_INT);
    }
}


