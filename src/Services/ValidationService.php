<?php

namespace ITBugTracking\Services;

use ITBugTracking\Hydrators\IssueHydrator;
use ITBugTracking\Hydrators\SeverityHydrator;
use Exception;
use PDO;

class ValidationService
{
    public static function checkRequiredDataExists($data): bool
    {
        return !empty($data['name']) && !empty($data['title']) && !empty($data['severity']) && !empty($data['department']);
    }

    public static function validateStringInput(string $input, int $limit): string | false {
        if ($limit < 1){
            throw new Exception("Limit must be a positive integer");
        }
        $output = trim($input);
        if (strlen($output) > $limit) {
            $output = false;
        } else {
            $output = htmlspecialchars($output);
        }
        return $output;
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
