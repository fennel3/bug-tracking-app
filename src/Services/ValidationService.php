<?php
namespace ITBugTracking\Services;

use ITBugTracking\Factories\DatabaseConnector;
use ITBugTracking\Hydrators\IssueHydrator;

$db = DatabaseConnector::connect();


class ValidationService
{
    //validate if fields are entered
    public static function createIssue($db, $issue)
    {
        if (empty($issue['name']) || empty($issue['title']) || empty($issue['severity']) || empty($issue['department'])) {
            return null;
        }
        $issue = self::limitCharLength($issue);
        $issue = self::setToNull($issue);
        $issue = self::descriptionLimitCharLength($issue);
        $issue = self::checkInteger($issue);

        return $db->lastInsertId();
    }

    //sanitize 255 character limits
    private static function limitCharLength($issue)
    {
        if (strlen($issue['name']) > 255) {
            $issue['name'] = substr($issue['name'], 0, 255);
        }
        if (strlen($issue['title']) > 255) {
            $issue['title'] = substr($issue['title'], 0, 255);
        }
        return $issue;
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
