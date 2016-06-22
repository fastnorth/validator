<?php

namespace FastNorth\Validator\Constraint;

/**
 * Boolean
 *
 * Checks if value is boolean
 */
class Boolean extends AbstractConstraint
{
    const NOT_BOOLEAN = 'not_boolean';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        if (!is_bool($value)) {
            return $this->fail(self::NOT_BOOLEAN);
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
            self::NOT_BOOLEAN => 'The value provided is not a valid boolean'
        ];
    }
}
