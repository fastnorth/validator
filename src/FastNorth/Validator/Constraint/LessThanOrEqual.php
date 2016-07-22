<?php

namespace FastNorth\Validator\Constraint;

/**
 * LessThanOrEqual
 *
 * Compares against a value to check for less than or equal
 */
class LessThanOrEqual extends AbstractConstraint
{
    const TOO_HIGH = 'value_too_high';
    const EMPTY_VALUE = 'missing';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        if (empty($value)) {
            return $this->fail(self::EMPTY_VALUE);
        }

        if ($value > $this->getOption('compared_value')) {
            return $this->fail(self::TOO_HIGH);
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
             self::TOO_HIGH    => 'This value should be less than or equal to {{ compared_value }}',
             self::EMPTY_VALUE => 'This field should not be empty',
        ];
    }
}
