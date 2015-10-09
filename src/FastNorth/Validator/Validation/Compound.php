<?php

namespace FastNorth\Validator\Validation;

use FastNorth\Validator\ValidationInterface;

/**
 * Compound
 *
 * Compound validation, combines multiple Validations
 */
class Compound implements ValidationInterface
{
    /**
     * Per key hash of validations
     *
     * @param ValidationInterface[]
     */
    private $validations = [];

    private $key;

    public function __construct($key = null)
    {
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function passes()
    {
        foreach($this->validations as $validation) {
            if (!$validation->passes()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getMessages()
    {
        $messages = [];

        foreach($this->validations as $key => $validation) {
            if (!$validation->passes()) {
                $messages = array_merge($messages, $validation->getMessages());
            }
        }

        if (!empty($this->key)) {
            return [$this->key => $messages];
        }
        return $messages;
    }

    /**
     * Add a validation
     *
     * @param string $key
     * @param ValidationInterface $validation
     */
    public function add($key, ValidationInterface $validation)
    {
        $this->validations[$key] = $validation;
    }
}
