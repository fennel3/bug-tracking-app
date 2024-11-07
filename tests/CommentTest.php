<?php


use ITBugTracking\Entities\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{

    public function testComment_JsonSerialize_success()
    {
        $comment = new Comment();

        $comment->id = 1;
        $comment->name = "Name";
        $comment->comment = "A comment.";
        $comment->date_created = "05/11/2024";
        $comment->issue_id = 5;

        $expected = json_encode([
            'id' => 1,
            'title' => "Name",
            'comment' => "A comment.",
            'date_created' => "05/11/2024",
            'issue_id' => 5
        ]);

        $actual = json_encode($comment);

        $this->assertEquals($expected, $actual);
    }

    public function testComment_JsonSerialize_malformedInputs()

    {
        $comment = new Comment();

        $this->expectException(\Entities\TypeError::class);

        $comment->id = 'not an ID';
        $comment->name = "Name";
        $comment->comment = "A comment.";
        $comment->date_created = "05/11/2024";
        $comment->issue_id = 5;

        json_encode($comment);
    }
}
