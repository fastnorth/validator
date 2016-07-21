<?php

namespace FastNorth\Validator\Constraint;

/**
 * LessThan
 *
 * Compares against a value to check for less than
 */
class LessThan extends AbstractConstraint
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

        if ($value >= $this->getOption('compared_value')) {
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
             self::TOO_HIGH    => 'This value should be less than {{ compared_value }}',
             self::EMPTY_VALUE => 'This field should not be empty',
        ];
    }
}
