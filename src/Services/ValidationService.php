<?php
namespace ITBugTracking\Services;

use ITBugTracking\Entities\Issue;
use ITBugTracking\Entities\Severity;
class ValidationService
{

    public static function validateCreateIssue($data)
    {
        if (empty($data['reporter']) || empty($data['title']) || empty($data['severity']) || empty($data['department'])) {
            return null;
        }

    }
    

    //sanitize 255 character limits
    private static function limitCharLength($checkedString)
    {
        if (strlen($checkedString) > 255) {
            $checkedString = substr($checkedString, 0, 255);
        }
        return $checkedString;
    }


    //and check if description field is entered, set to null if not
    private static function setToNull($data) {
        if (empty($data['description'])) {
            $data['description'] = null;
        }
        return $data;
    }
    // 100000 character limit for description
    private static function descriptionLimitCharLength($data) {
        if (strlen($data['description']) > 10000) {
            $data['description'] = substr($data['description'], 0, 10000);
        }return $data;
    }

//        check severity and department are integers

    private static function checkInteger($data) {
        if (!filter_var($data['severity'], FILTER_VALIDATE_INT) === false) {
            return $data['severity'];
        } else {
            $data['severity'] = null;
        }
        if (!filter_var($data['department'], FILTER_VALIDATE_INT) === false) {
            return $data['department'];
        } else {
            $data['department'] = null;
        }
        return $data;
    }
}


