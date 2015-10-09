<?php

namespace FastNorth\Validator;

use FastNorth\Validator\Constraint\ConstraintInterface as Constraint;

/**
 * ValidatableInterface.
 *
 * Something that can be validated
 */
interface ValidatableInterface
{
    /**
     * Add a constraint.
     *
     * The second parameter $when is a callback that gets the field value (and
     * data context) and can be used to disable the constraint all together
     *
     * @param Constraint $constraint
     * @param callable   $when
     *
     * @return self
     */
    public function should(Constraint $constraint, callable $when = null);

    /**
     * Get the constraints for a value/context combination.
     *
     * Should look at the $when callback specified in should()
     *
     * @param mixed $value
     * @param mixed $context optional context
     *
     * @return Constraint[]
     */
    public function getConstraints($value, $context = null);
}
