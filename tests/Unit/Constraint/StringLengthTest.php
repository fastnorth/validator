<?php

namespace Tests\Unit\Constraint;

use FastNorth\Validator\Constraint;

/**
 * StringLengthTest
 *
 * Tess st
 */
class StringLengthTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function itOutputsInterpolatedMessageWhenTooShort()
    {
        $constraint = new Constraint\StringLength(['min' => 5, 'max' => 25]);
        $validation = $constraint->validate('foo');
        $messages = $validation->getMessages();
        $this->assertFalse($validation->passes());
        $this->assertEquals(
            'The value you have provided is shorter than the required 5 characters',
            $messages[Constraint\StringLength::TOO_SHORT]
        );
    }

    /** @test */
    public function itOutputsInterpolatedMessageWhenTooLong()
    {
        $constraint = new Constraint\StringLength(['min' => 3, 'max' => 5]);
        $validation = $constraint->validate('foobarbaz');
        $messages = $validation->getMessages();
        $this->assertFalse($validation->passes());
        $this->assertEquals(
            'The value you have provided is longer than the maximum 5 characters',
            $messages[Constraint\StringLength::TOO_LONG]
        );
    }
}
