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
    public function itOutputsInterpolatedMessage()
    {
        $constraint = new Constraint\StringLength(['min' => 5, 'max' => 25]);
        $validation = $constraint->validate('foo');
        $messages = $validation->getMessages();
        var_dump($messages);
        $this->assertEquals(
            'The value you have provided is shorter than the required 5 characters',
            $messages[Constraint\StringLength::TOO_SHORT]
        );
    }
}
