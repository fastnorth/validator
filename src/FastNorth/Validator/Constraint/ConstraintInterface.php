<?php

namespace FastNorth\Validator\Constraint;

use FastNorth\Validator\ValidationInterface;

/**
 * ConstraintInterface.
 *
 * Single constraint
 */
interface ConstraintInterface
{
    /**
     * Validate a value inside of an (optional) context.
     *
     * @param string $value
     * @param mixed  $context
     *
     * @return ValidationInterface
     */
    public function validate($value, $context = null);
}
