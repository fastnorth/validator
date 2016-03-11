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
     * @param mixed $what
     *
     * @return ValidationInterface
     */
    public function validate($what);

    /**
     * Validate only one field of the definition given some data
     *
     * This can be useful when you don't have a full data set
     *
     * @param string $field
     * @param mixed  $what
     *
     * @return ValidationInterface
     */
    public function validateField($field, $what);

    /**
     * Get the value contained in a field, which is to be validated
     *
     * @param mixed $field
     *
     * @return mixed
     */
    public function getFieldValue($field, $data);
}
