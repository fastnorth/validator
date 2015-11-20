<?php

namespace FastNorth\Validator\Constraint;

use FastNorth\Validator\Constraint\Exception\OptionMissingException;
use FastNorth\Validator\Validation;

/**
 * AbstractConstraint.
 *
 * Abstract constraint
 */
abstract class AbstractConstraint implements ConstraintInterface
{
    protected $options = [];

    protected $messages = [];

    /**
     * Constructor
     *
     * @param array $options
     * @param array $messages
     */
    public function __construct($options = [], $messages = [])
    {
        $this->options = array_merge($this->getDefaultOptions(), $options);
        $this->messages = array_merge($this->getDefaultMessages(), $messages);

        // Make sure required options are there
        foreach($this->getRequiredOptions() as $option) {
            if (!isset($this->options[$option])) {
                throw new OptionMissingException(sprintf('Required option "%s" is missing', $option));
            }
        }
    }

    /**
     * Get the default validation messages
     *
     * Overload with defaults
     *
     * @return string[]
     */
    protected function getDefaultMessages()
    {
        return [];
    }

    /**
     * Get the default options
     *
     * Overload with defaults
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [];
    }

    protected function getRequiredOptions()
    {
        return [];
    }

    /**
     * Get a validation message by key
     *
     * @param string $key
     * @return string
     */
    protected function getMessage($key)
    {
        return $this->messages[$key];
    }

    /**
     * Get an option by key
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    protected function getOption($key, $default = null)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }
        return is_callable($default) ? $default($key) : $default;
    }

    /**
     * Get all options
     *
     * @return array
     */
    protected function getOptions()
    {
        return $this->options;
    }

    /**
     * Fail validation.
     *
     * @param string|string[] $messages identifiers of the messages (keys)
     *
     * @return Validation
     */
    protected function fail($messages, array $interpolate = [])
    {
        $fullMessages = [];

        foreach ((array) $messages as $key) {
            $fullMessages[$key] = self::interpolate($this->getMessage($key), $interpolate);
        }

        return new Validation(false, $fullMessages);
    }

    /**
     * Pass validation.
     *
     * @return Validation
     */
    protected function pass()
    {
        return new Validation(true);
    }

    /**
     * Interpolate a string using `{{ foo }}` placeholders
     *
     * @param string $string
     * @param array $variables
     */
    protected static function interpolate($string, array $variables = [])
    {
        foreach($variables as $key => $value) {
            $string = preg_replace(
                sprintf('/\{\{\s*%s\s*\}\}/', $key),
                $value,
                $string
            );
        }

        return $string;
    }
}

