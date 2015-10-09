<?php

namespace FastNorth\Validator\Definition;

use FastNorth\Validator\ValidatableInterface;

/**
 * FieldInterface
 *
 * Defines a single field in a definition
 */
interface FieldInterface extends ValidatableInterface
{
    /**
     * Get the field name.
     *
     * @return string
     */
    public function getField();

    /**
     * Mark field as required
     *
     * @param bool $required
     * @param string $message
     *
     * @return self
     */
    public function required($required = true, $message = null);
}
