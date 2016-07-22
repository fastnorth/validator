<?php

namespace FastNorth\Validator\Constraint;

/**
 * GreaterThanOrEqual
 *
 * Compares against a value to check for greater than or equal
 */
class GreaterThanOrEqual extends AbstractConstraint
{
    const TOO_LOW = 'value_too_low';
    const EMPTY_VALUE = 'missing';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        if (empty($value)) {
            return $this->fail(self::EMPTY_VALUE);
        }

        if ($value < $this->getOption('compared_value')) {
            return $this->fail(self::TOO_LOW);
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
             self::TOO_LOW     => 'This value should be greater than or equal to {{ compared_value }}',
             self::EMPTY_VALUE => 'This field should not be empty',
        ];
    }
}
