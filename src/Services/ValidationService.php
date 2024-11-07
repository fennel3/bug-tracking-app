<?php
namespace ITBugTracking\Services;

use ITBugTracking\Entities\Issue;
use ITBugTracking\Entities\Severity;
class ValidationService
{
    //validate if fields are entered, call the validation functions
//    public static function validateCreateIssue($data)
//    {
////        if (empty($severity['name']) || empty($issue['title']) || empty($issue['severity']) || empty($issue['department'])) {
////            return null;
////        }
//
//            'reporter' => $data['name'],
//            'department' => $data['department'],
//            'title' => $data['title'],
//            'description' => $data['description'],
//            'severity' => $data['severity'],
//
//
//
//
//    }

    //sanitize 255 character limits
    private static function limitCharLength($checkedString)
    {
        if (strlen($checkedString) > 255) {
            $checkedString = substr($checkedString, 0, 255);
        }
        return $checkedString;
    }


    //and check if description field is entered, set to null if not
    private static function setToNull($issue) {
        if (empty($issue['description'])) {
            $issue['description'] = null;
        }
        return $issue;
    }
    // 100000 character limit for description
    private static function descriptionLimitCharLength($issue) {
        if (strlen($issue['description']) > 10000) {
            $issue['description'] = substr($issue['description'], 0, 10000);
        }return $issue;
    }

        //check severity and department are integers
//    private static function checkInteger($issue) {
//        if (filter_var($issue['severity'], FILTER_VALIDATE_INT) !== true) {
//                $issue['severity'] = null;
//            } else {
//                return $issue['severity'];
//            }
//
//        if (filter_var($issue['department'], FILTER_VALIDATE_INT) !== true) {
//                $issue['department'] = null;
//            } else {
//                return $issue['department'];
//            }
//            return $issue;
//        }
    private static function checkInteger($issue) {
        if (!filter_var($issue['severity'], FILTER_VALIDATE_INT) === false) {
            return $issue['severity'];
        } else {
            $issue['severity'] = null;
        }
        if (!filter_var($issue['department'], FILTER_VALIDATE_INT) === false) {
            return $issue['department'];
        } else {
            $issue['department'] = null;
        }
        return $issue;
    }
}


