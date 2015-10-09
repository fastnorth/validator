<?php

namespace FastNorth\Validator\Constraint;

/**
 * Numeric
 *
 * Checks if value is numeric
 */
class Numeric
{
    const NOT_NUMERIC = 'not_numeric';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        if (!is_numeric($value)) {
            return $this->fail(self::NOT_NUMERIC);
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
            self::NOT_NUMERIC => 'The value provided is not numeric'
        ];
    }
}
