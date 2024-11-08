<?php

namespace ITBugTracking\Services;

use ITBugTracking\Hydrators\IssueHydrator;
use ITBugTracking\Hydrators\SeverityHydrator;
use PDO;

class ValidationService
{
    public static function checkRequiredDataExists($data): bool
    {
        return !empty($data['name']) && !empty($data['title']) && !empty($data['severity']) && !empty($data['department']);
    }

    public static function validateStringInput(string $input, int $limit): string | false {
        $output = trim($input);
        if (strlen($output) > $limit) {
            $output = false;
        } else {
            $output = htmlspecialchars($output);
        }
        return $output;
    }

    public static function descriptionLimitCharLength($data)
    {
        if (strlen($data) > 10000) {
            $data = substr($data, 0, 10000);
        }
        return $data;
    }

    public static function checkSeverityExists(PDO $db, int $severity): bool {
        $severities = SeverityHydrator::getSeverityIds($db);
        return in_array($severity, $severities);
    }

    public static function checkDepartmentExists(PDO $db, int $department): bool {
        $departments = IssueHydrator::getDepartmentIds($db);
        return in_array($department, $departments);
    }

}
