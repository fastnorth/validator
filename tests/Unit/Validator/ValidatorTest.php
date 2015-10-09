<?php

namespace Unit\Validator;

use FastNorth\Validator\Validator;
use FastNorth\Validator\Definition;
use FastNorth\Validator\Constraint;

/**
 * ValidatorTest.
 *
 * Validator Test Case
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function itValidatesSingleField()
    {
        $definition = new Definition;

        $definition
            ->field('foo')
            ->should(new Constraint\StringLength(
                ['max' => 5],
                [Constraint\StringLength::TOO_LONG => 'TOO LONG']
            ));

        $validator = new Validator($definition);

        $validation = $validator->validate(array('foo' => 'foo'));

        $this->assertTrue($validation->passes());
    }

    /** @test */
    public function itInValidatesSingleField()
    {
        $definition = new Definition;

        $definition
            ->field('foo')
            ->should(new Constraint\StringLength(
                ['max' => 5],
                [Constraint\StringLength::TOO_LONG => 'TOO LONG']
            ));

        $validator = new Validator($definition);

        $validation = $validator->validate(array('foo' => 'foobarbaz'));

        $this->assertFalse($validation->passes());

        // Assert structure of error messages
        $this->assertCount(1, $validation->getMessages());
        $this->assertArrayHasKey('foo',$validation->getMessages());
        $this->assertArrayHasKey(Constraint\StringLength::TOO_LONG, $validation->getMessages()['foo']);
        $this->assertEquals('TOO LONG', $validation->getMessages()['foo'][Constraint\StringLength::TOO_LONG]);
    }

    /** @test */
    public function itDoesNotValidateFieldsWhenGuardingClosureReturnsFalse()
    {
        $definition = new Definition;

        $definition
            ->field('foo', self::alwaysFalse())
            ->should(
                new Constraint\StringLength(
                    ['max' => 5],
                    [Constraint\StringLength::TOO_LONG => 'TOO LONG']
                )
            );

        $validator = new Validator($definition);

        $validation = $validator->validate(array('foo' => 'foobarbaz'));

        $this->assertTrue($validation->passes());
    }

    /** @test */
    public function itValidatesFieldsWhenGuardingClosureReturnsTrue()
    {
        $definition = new Definition;

        $definition
            ->field('foo', self::alwaysTrue())
            ->should(
                new Constraint\StringLength(
                    ['max' => 5],
                    [Constraint\StringLength::TOO_LONG => 'TOO LONG']
                )
            );

        $validator = new Validator($definition);

        $validation = $validator->validate(array('foo' => 'foobarbaz'));

        $this->assertFalse($validation->passes());
    }

    /** @test */
    public function itSkipsConstraintsWhenGuardingClosureReturnsFalse()
    {
        $definition = new Definition;

        $definition
            ->field('foo')
            ->should(
                new Constraint\StringLength(
                    ['max' => 5],
                    [Constraint\StringLength::TOO_LONG => 'TOO LONG']
                ),
                self::alwaysFalse()
        );

        $validator = new Validator($definition);

        $validation = $validator->validate(array('foo' => 'foobarbaz'));

        $this->assertTrue($validation->passes());
    }

    /** @test */
    public function itDoesNotSkipConstraintsWhenGuardingClosureReturnsTrue()
    {
        $definition = new Definition;

        $definition
            ->field('foo')
            ->should(
                new Constraint\StringLength(
                    ['max' => 5],
                    [Constraint\StringLength::TOO_LONG => 'TOO LONG']
                ),
                self::alwaysTrue()
        );

        $validator = new Validator($definition);

        $validation = $validator->validate(array('foo' => 'foobarbaz'));

        $this->assertFalse($validation->passes());

        // Assert structure of error messages
        $this->assertCount(1, $validation->getMessages());
        $this->assertArrayHasKey('foo',$validation->getMessages());
        $this->assertArrayHasKey(Constraint\StringLength::TOO_LONG, $validation->getMessages()['foo']);
        $this->assertEquals('TOO LONG', $validation->getMessages()['foo'][Constraint\StringLength::TOO_LONG]);
    }

    /** @test */
    public function itDetectsMissingFieldsWhenTheyWereRequired()
    {
        $definition = new Definition;

        $definition
            ->field('foo')
            ->required(true, 'foorequired');

        $validator = new Validator($definition);

        $validation = $validator->validate(array('bar' => 'bar'));

        $this->assertFalse($validation->passes());
    }

    /** @test */
    public function itSkipsRequiredCheckWhenFieldDisabled()
    {
        $definition = new Definition;

        $definition
            ->field('foo')
            ->required(false);

        $definition
            ->field('foo', self::alwaysFalse(false))
            ->required(true);

        $validator = new Validator($definition);

        $validation = $validator->validate(array('bar' => 'bar'));

        $this->assertFalse($validation->passes());
    }

    private static function alwaysTrue($checkValue = true)
    {
        return self::makeClosure(true, $checkValue);
    }

    private static function alwaysFalse($checkValue = true)
    {
        return self::makeClosure(false, $checkValue);
    }

    private static function makeClosure($return, $checkValue = true)
    {
        return function($value, $context) use ($return, $checkValue) {
            if ($checkValue && empty($value) || empty($context)) {
                throw new \RuntimeException('Empty value/context');
            }

            return $return;
        };
    }
}
