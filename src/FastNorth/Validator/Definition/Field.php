<?php

namespace FastNorth\Validator\Definition;

use FastNorth\Validator\Constraint\ConstraintInterface as Constraint;
use FastNorth\Validator\Constraint\NotEmpty as NotEmptyConstraint;

/**
 * Field
 *
 * Field validator definition
 */
class Field implements FieldInterface
{
    /**
     * Field
     *
     * @param string
     */
    private $field;

    /**
     * Validators
     *
     * array of ['validator' => Validator, 'when' => callback|void]
     *
     * @var array
     */
    private $should = [];

    /**
     * Constructor
     *
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @inheritDoc
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @inheritDoc
     */
    public function should(Constraint $constraint, callable $when = null)
    {
        $this->should[] = [
            'validator' => $constraint,
            'when'      => $when
        ];
    }

    /**
     * @inheritDoc
     */
    public function required($required = true, $message = null)
    {
        if (!empty($message)) {
            $this->should(new NotEmptyConstraint([], [NotEmptyConstraint::EMPTY_VALUE => $message]));
        } else {
            $this->should(new NotEmptyConstraint);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConstraints($value, $context = null)
    {
        $constraints = [];
        foreach($this->should as $should) {

            // Run "when" callback
            $validate = true;
            if ($should['when'] !== null) {
                $validate = $should['when']($value, $context);
            }

            if ($validate) {
                $constraints[] = $should['validator'];
            }
        }

        return $constraints;
    }
}
