<?php


class ValidationServiceTest extends \PHPUnit\Framework\TestCase
{
    public function ValidationServiceTestSuccess()
    {
        $issue = new Issue();

        $issue->name = "Kiel";
        $issue->department = "2";
        $issue->title = "elit sodales scelerisque mauris sit amet eros suspendisse accumsan";
        $issue->description = "In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.

Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.";
        $issue->severity = "1";

        $expected = json_encode([
            'name' => "Kiel",
        'department' => 2,
        'title' => "elit sodales scelerisque mauris sit amet eros suspendisse accumsan",
        'description' => "In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.

Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.",
    'severity' => 1]);


        $actual = json_encode($issue);
        $this->assertEquals($expected, $actual);
}
}