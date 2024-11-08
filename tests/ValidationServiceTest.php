<?php

namespace tests;

use Exception;
use ITBugTracking\Services\ValidationService;
use PHPUnit\Framework\TestCase;

class ValidationServiceTest extends TestCase
{
    public function testValidateStringInputsNormal()
    {
        $string = "Character Character Character Character Character Character Character Character Character Character";

        $expected = "Character Character Character Character Character Character Character Character Character Character";

        $actual = ValidationService::validateStringInput($string, 100);

        $this->assertEquals($expected, $actual);
    }

    public function testValidateStringInputs_ReturnFalse()
    {
        $string = "Character Character Character Character Character Character Character Character Character Character";

        $actual = ValidationService::validateStringInput($string, 10);

        $this->assertFalse($actual);
    }

    public function testValidateStringInputs_ZeroLimit()
    {
        $string = "Character Character Character Character Character Character Character Character Character Character";

        $this->expectException(Exception::class);

        ValidationService::validateStringInput($string, 0);
    }

    public function testValidateStringInputs_NegativeLimit()
    {
        $string = "Character Character Character Character Character Character Character Character Character Character";

        $this->expectException(Exception::class);

        ValidationService::validateStringInput($string, -1);
    }

    public function testValidateStringInputs_EmptyString()
    {
        $string = "";

        $expected = "";

        $actual = ValidationService::validateStringInput($string, 100);

        $this->assertEquals($expected, $actual);
    }

    public function testValidateStringInputs_Whitespace()
    {
        $string = "                             Character                               ";

        $expected = "Character";

        $actual = ValidationService::validateStringInput($string, 100);

        $this->assertEquals($expected, $actual);
    }

    public function testValidateStringInputs_WhitespaceDoesntLimit()
    {
        $string = "                             Character                               ";

        $expected = "Character";

        $actual = ValidationService::validateStringInput($string, 50);

        $this->assertEquals($expected, $actual);
    }

    public function testValidateStringInputs_LimitWithWhitespace()
    {
        $string = "                             Some Characters                               ";

        $actual = ValidationService::validateStringInput($string, 10);

        $this->assertFalse($actual);
    }

}
