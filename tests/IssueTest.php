<?php

namespace tests;

use ITBugTracking\Entities\Issue;
use PHPUnit\Framework\TestCase;
use TypeError;
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
            'date_created' => "2024-11-05 15:56:55",
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
            'date_created' => "2024-11-05 15:56:55",
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

        $expected = json_encode([
            'id' => 7,
            'title' => "A Title",
            'summary' => null,
            'severity' => "Severe",
            'date_created' => "2024-11-05 15:56:55",
            'comment_count' => 5,
            'completed' => false,
        ]);

        $actual = json_encode($issue);

        $this->assertEquals($expected, $actual);
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

        $expected = json_encode([
            'id' => 7,
            'title' => "A Title",
            'summary' => null,
            'severity' => "Severe",
            'date_created' => "2024-11-05 15:56:55",
            'comment_count' => 5,
            'completed' => true,
        ]);

        $actual = json_encode($issue);

        $this->assertEquals($expected, $actual);
    }

    public function testIssueJsonSerialize_MalformedInputs()
    {
        $issue = new Issue();

        $this->expectException(TypeError::class);

        $issue->id = "Hello";
        $issue->title = 1;
        $issue->summary =  2;
        $issue->severity = 3;
        $issue->date_created = 4;
        $issue->comment_count = 5;
        $issue->completed = "false";

        json_encode($issue);

    }
}
