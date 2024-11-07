<?php

namespace tests;

use Exception;
use ITBugTracking\Entities\Issue;
use PHPUnit\Framework\TestCase;
use TypeError;
use function PHPUnit\Framework\assertEquals;

class IssueTest extends TestCase
{
    public function testIssueJsonSerialize_success()
    {
        $issue = new Issue();

        $issue->id = 7;
        $issue->title = "A Title";
        $issue->summary = "A summary of an issue";
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05 15:56:55";
        $issue->comment_count = 5;
        $issue->completed = false;

        $expected = json_encode([
            'id' => 7,
            'title' => "A Title",
            'summary' => "A summary of an issue",
            'severity' => "Severe",
            'date_created' => "05/11/2024",
            'comment_count' => 5,
            'completed' => false,
        ]);

        $actual = json_encode($issue);

        $this->assertEquals($expected, $actual);
    }


    public function testIssueJsonSerialize_nullSummary_success()
    {
        $issue = new Issue();

        $issue->id = 7;
        $issue->title = "A Title";
        $issue->summary = null;
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05 15:56:55";
        $issue->comment_count = 5;
        $issue->completed = false;

        $expected = json_encode([
            'id' => 7,
            'title' => "A Title",
            'summary' => "",
            'severity' => "Severe",
            'date_created' => "05/11/2024",
            'comment_count' => 5,
            'completed' => false,
        ]);

        $actual = json_encode($issue);

        $this->assertEquals($expected, $actual);
    }

    public function testIssueJsonSerialize_completed_success()
    {
        $issue = new Issue();

        $issue->id = 7;
        $issue->title = "A Title";
        $issue->summary = "This is a summary";
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05 15:56:55";
        $issue->comment_count = 5;
        $issue->completed = true;

        $expected = json_encode([
            'id' => 7,
            'title' => "A Title",
            'summary' => "This is a summary",
            'severity' => "Severe",
            'date_created' => "05/11/2024",
            'comment_count' => 5,
            'completed' => true,
        ]);

        $actual = json_encode($issue);

        $this->assertEquals($expected, $actual);
    }

    public function testIssueJsonSerialize_malformedInputs()
    {
        $issue = new Issue();

        $this->expectException(TypeError::class);

        $issue->id = "Hello";
        $issue->title = 1;
        $issue->summary = 2;
        $issue->severity = 3;
        $issue->date_created = 4;
        $issue->comment_count = 5;
        $issue->completed = "false";

        json_encode($issue);
    }

    public function testGetDate_success()
    {
        $issue = new Issue();
        $issue->date_created = "2024-11-05 15:56:55";
        $expected = "05/11/2024";
        $actual = $issue->getDate();
        assertEquals($actual, $expected);
    }

    public function testGetDate_malformed_string()
    {
        $issue = new Issue();
        $issue->date_created = "i am a date";
        $this->expectException(Exception::class);
        $issue->getDate();
    }
}

