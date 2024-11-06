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

    public function testIssueJsonSerialize_longDescriptionSuccess()
    {
        $issue = new Issue();

        $issue->id = 7;
        $issue->title = "A Title";
        $issue->summary = "In a world where technology evolves rapidly, it's essential to keep learning and adapting to new ski";
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05 15:56:55";
        $issue->comment_count = 5;
        $issue->completed = false;

        $expected = json_encode([
            'id' => 7,
            'title' => "A Title",
            'summary' => "In a world where technology evolves rapidly, it's essential to keep learning and adapting to new ski",
            'severity' => "Severe",
            'date_created' => "05/11/2024",
            'comment_count' => 5,
            'completed' => false,
        ]);

        $actual = json_encode($issue);

        $this->assertEquals($expected, $actual);
    }

    public function testIssueJsonSerialize_nullableDescriptionSuccess()
    {
        $issue = new Issue();

        $issue->id = 7;
        $issue->title = "A Title";
        $issue->summary = null;
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05 15:56:55";
        $issue->comment_count = 5;
        $issue->completed = false;

        $result = $issue->jsonSerialize();

        $this->assertNull($result['summary']);
    }

    public function testIssueJsonSerialize_nullableCommentCountSuccess()
    {
        $issue = new Issue();

        $issue->id = 7;
        $issue->title = "A Title";
        $issue->summary = "Hello";
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05 15:56:55";
        $issue->comment_count = null;
        $issue->completed = false;

        $result = $issue->jsonSerialize();

        $this->assertNull($result['comment_count']);
    }

    public function testIssueJsonSerialize_completedTrueSuccess()
    {
        $issue = new Issue();

        $issue->id = 7;
        $issue->title = "A Title";
        $issue->summary = null;
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05 15:56:55";
        $issue->comment_count = 5;
        $issue->completed = true;

        $result = $issue->jsonSerialize();

        $this->assertTrue($result['completed']);
    }

    public function testIssueJsonSerialize_completedFalseSuccess()
    {
        $issue = new Issue();

        $issue->id = 7;
        $issue->title = "A Title";
        $issue->summary = null;
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05 15:56:55";
        $issue->comment_count = 5;
        $issue->completed = false;

        $result = $issue->jsonSerialize();

        $this->assertFalse($result['completed']);
    }

    public function testIssueJsonSerialize_MalformedInputs()
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

    public function testGetDate_Success()
    {
        $date = "2024-11-05 15:56:55";
        $expected = "05/11/2024";
        $actual = Issue::getDate($date);
        assertEquals($actual, $expected);
    }

    public function testGetDate_MalformedArray()
    {
        $date = [2024, 11, 05, 15, 56, 55];
        $this->expectException(TypeError::class);
        Issue::getDate($date);

    }

    public function testGetDate_MalformedString()
    {
        $date = "i am a date";
        $this->expectException(Exception::class);
        Issue::getDate($date);
    }
}
