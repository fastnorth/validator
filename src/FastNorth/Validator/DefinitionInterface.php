<?php

namespace FastNorth\Validator;

use Symfony\Component\Validator\Constraint;
use FastNorth\Validator\Definition\FieldInterface as FieldDefinition;

/**
 * DefinitionInterface.
 *
 * Defines a set of validators on a per field basis
 *
 * Every field will get one (or more) field definitions, each of which can be
 * conditional based on a callback.
 */
interface DefinitionInterface
{
    /**
     * Get a field for validation.
     *
     * You can pass a second parameter $when, that disables/enables validation
     * for the field all together
     *
     * @param string   $field
     * @param callable $when
     *
     * @return FieldDefinition
     */
    public function field($field, callable $when = null);

    /**
     * Get the names of all fields for which there are constraints.
     *
     * @return string[]
     */
    public function getFields();

    /**
     * Get the constraints for a field.
     *
     * The value/data are used to meet conditionals
     *
     * @param string $field field name
     * @param mixed  $value field value
     * @param mixed  $data
     *
     * @return Constraint[]
     */
    public function getConstraints($field, $value, $data);
}
