<?php

namespace FastNorth\Validator\Constraint;

/**
 * NotEmpty
 *
 * Does not allow `empty()` values
 */
class NotEmpty extends AbstractConstraint
{
    const EMPTY_VALUE = 'missing';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        if (empty($value)) {
            return $this->fail(self::EMPTY_VALUE);
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
            self::EMPTY_VALUE => 'This field should not be empty'
        ];
    }
}
