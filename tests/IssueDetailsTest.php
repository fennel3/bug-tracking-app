<?php

namespace tests;

use ITBugTracking\Entities\IssueDetails;
use PHPUnit\Framework\TestCase;
use TypeError;

class IssueDetailsTest extends TestCase
{

    public function testIssueDetailsJsonSerialize_malformedInputs()

    {
            $issueDetails = new IssueDetails();

            $this->expectException(TypeError::class);

            $issueDetails->id = 'hello';
            $issueDetails->title = 2;
            $issueDetails->severity = 3;
            $issueDetails->date_created = 'this is a date';
            $issueDetails->comment_count = 'comments';
            $issueDetails->reporter = 4;
            $issueDetails->department = 'department';
            $issueDetails->summary = 2;
            $issueDetails->comments = [1, 2, 3];

            json_encode($issueDetails);
    }
}
