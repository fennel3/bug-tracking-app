<?php



use ITBugTracking\Entities\IssueDetails;
use PHPUnit\Framework\TestCase;

class IssueDetailsTest extends TestCase
{
    public function testJsonSerialize_success()
    {
        $issueDetails = new IssueDetails();

        $issueDetails->id = 5;
        $issueDetails->title = "A Title";
        $issueDetails->summary = "This is a description.";
        $issueDetails->severity = "Severe";
        $issueDetails->date_created = "2024-11-05 15:56:55";
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

    public function testJsonSerialize_NullComments_success()
    {
        $issueDetails = new IssueDetails();

        $issueDetails->id = 5;
        $issueDetails->title = "A Title";
        $issueDetails->summary = "This is a description.";
        $issueDetails->severity = "Severe";
        $issueDetails->date_created = "2024-11-05 15:56:55";
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
}
