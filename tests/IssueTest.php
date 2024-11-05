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
        $issue->description = "In a world where technology evolves rapidly, it's essential to keep learning and adapting to new skills and information to stay ahead.";
        $issue->severity = "Severe";
        $issue->date_created = "2024-11-05";
        $issue->comment_count = 5;
        $issue->completed = false;

        $expected = json_encode([
            'id' => 7,
            'title' => "A Title",
            'summary' => "In a world where technology evolves rapidly, it's essential to keep learning and adapting to new ski",
            'severity' => "Severe",
            'date_created' => "2024-11-05",
            'comment_count' => 5,
            'completed' => false,
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
        $issue->description =  2;
        $issue->severity = 3;
        $issue->date_created = 4;
        $issue->comment_count = 5;
        $issue->completed = "false";

        json_encode($issue);

    }
}
