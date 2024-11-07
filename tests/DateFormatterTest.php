<?php

namespace tests;

use Exception;
use ITBugTracking\Services\DateFormatter;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class DateFormatterTest extends TestCase
{

    public function testFormatDate_success()
    {
        $dateFormatter = new DateFormatter();
        $expected = "05/11/2024";
        $actual = $dateFormatter->formatDate("2024-11-05 15:56:55");
        assertEquals($actual, $expected);
    }

    public function testFormatDate_malformed_string()
    {
        $dateFormatter = new DateFormatter();
        $this->expectException(Exception::class);
        $dateFormatter->formatDate("I am a date");
    }
}
