<?php

namespace FastNorth\Validator;

/**
 * ValidatorInterface.
 *
 * Validator
 *
 *
 */
interface ValidatorInterface
{
    /**
     * Constructor
     *
     * @param DefinitionInterface $definition
     */
    public function __construct(DefinitionInterface $definition);

    /**
     * Validate some data.
     *
     * Sets the internal data for the validator and returns the validation
     * status
     *
     * @param mixed $what
     *
     * @return ValidationInterface
     */
    public function validate($what);

    /**
     * Get the value contained in a field, which is to be validated
     *
     * Can only be called *after* validate()
     *
     * @param mixed $field
     *
     * @return mixed
     */
    public function getFieldValue($field);
}
