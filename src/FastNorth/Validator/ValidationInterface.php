<?php

namespace FastNorth\Validator;

/**
 * ValidationInterface.
 *
 * Result of validation
 */
interface ValidationInterface
{
    /**
     * Did the validation pass?
     *
     * @return bool
     */
    public function passes();

    /**
     * Get an iterable set of error messages
     *
     * @return string[]
     */
    public function getMessages();
}
