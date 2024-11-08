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
        $comment->date_created = "11/05/2024 00:00";
        $comment->issue_id = 5;

        $expected = json_encode([
            'name' => "Name",
            'comment' => "A comment.",
            'date_created' => "05/11/2024 00:00",
        ]);

        $actual = json_encode($comment);

        $this->assertEquals($expected, $actual);
    }

    public function testComment_JsonSerialize_malformedInputs()

    {
        $comment = new Comment();

        $this->expectException(TypeError::class);

        $comment->id = 'not an ID';
        $comment->name = "Name";
        $comment->comment = "A comment.";
        $comment->date_created = "05/11/2024";
        $comment->issue_id = 5;

        json_encode($comment);
    }
}
