<?php

namespace tests;

use ITBugTracking\Entities\IssueDetails;
use PHPUnit\Framework\TestCase;
use TypeError;

class IssueDetailsTest extends TestCase
{
    public function testIssueDetails_JsonSerialize_success()
    {
        $issueDetails = new IssueDetails();

        $issueDetails->id = 5;
        $issueDetails->title = "A Title";
        $issueDetails->summary = "This is a description.";
        $issueDetails->severity = "Severe";
        $issueDetails->date_created = "05/11/2024";
        $issueDetails->comment_count = 5;
        $issueDetails->reporter = "Joe Blogs";
        $issueDetails->department = 1;
        $issueDetails->comments = ["comment one", "comment two", "comment three"];

        $expected = json_encode([
            'id' => 5,
            'title' => "A Title",
            'severity' => "Severe",
            'date_created' => "05/11/2024",
            'comment_count' => 5,
            'reporter' => "Joe Blogs",
            'department' => 1,
            'description' => "This is a description.",
            'comments' => ["comment one", "comment two", "comment three"]
        ]);

        $actual = json_encode($issueDetails);

        $this->assertEquals($expected, $actual);
    }

    public function testIssueDetails_JsonSerialize_NullComments_success()
    {
        $issueDetails = new IssueDetails();

        $issueDetails->id = 5;
        $issueDetails->title = "A Title";
        $issueDetails->summary = "This is a description.";
        $issueDetails->severity = "Severe";
        $issueDetails->date_created = "05/11/2024";
        $issueDetails->comment_count = 5;
        $issueDetails->reporter = "Joe Blogs";
        $issueDetails->department = 1;
        $issueDetails->comments = null;

        $expected = json_encode([
            'id' => 5,
            'title' => "A Title",
            'severity' => "Severe",
            'date_created' => "05/11/2024",
            'comment_count' => 5,
            'reporter' => "Joe Blogs",
            'department' => 1,
            'description' => "This is a description.",
            'comments' => null
        ]);

        $actual = json_encode($issueDetails);

        $this->assertEquals($expected, $actual);
    }
    public function testIssueDetails_JsonSerialize_malformedInputs()

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
