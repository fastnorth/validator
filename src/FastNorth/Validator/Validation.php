<?php

namespace FastNorth\Validator;

/**
 * Validation.
 *
 * Single validation
 */
class Validation implements ValidationInterface
{
    /**
     * Passes validation?
     *
     * @param bool
     */
    private $passes;

    /**
     * Validation messages.
     *
     * @param string[]
     */
    private $messages;

    /**
     * Constructor.
     *
     * @param bool  $passes
     * @param array $messages
     */
    public function __construct($passes, array $messages = [])
    {
        $this->passes = $passes;
        $this->messages = $messages;
    }

    /**
     * {@inheritdoc}
     */
    public function passes()
    {
        return $this->passes;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
