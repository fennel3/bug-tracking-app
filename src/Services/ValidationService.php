<?php

namespace ITBugTracking\Services;

use ITBugTracking\Hydrators\SeverityHydrator;
use Exception;
use PDO;

class ValidationService
{

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
}
