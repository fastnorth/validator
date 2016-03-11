<?php

namespace FastNorth\Validator\Constraint;

/**
 * Callback
 *
 * Runs callback to validate
 *
 * The callback can return true, false, or a message key. When it returns `false` the `INVALID` message will be used,
 * if it returns anything else it is assumed that you've added a message matching it to the options.
 *
 * @see AbstractConstraint::__construct()
 */
class Callback extends AbstractConstraint
{
    CONST INVALID = 'invalid';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        /** @var Callable $callback */
        $callback = $this->getOption('callback');

        // Result from the callback, either true, false, or a message code
        $callbackResult = $callback($value, $context);

        // When the callback returns a boolean, use the built-in "INVALID" failure (or pass)
        if (is_bool($callbackResult)) {
            if ($callbackResult) {
                return $this->pass();
            }
            return $this->fail(self::INVALID);
        }

        // Otherwise assume failure and use the returned value as the message key
        $this->fail($callbackResult);
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
            self::INVALID => 'Invalid value',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getRequiredOptions()
    {
        return ['callback'];
    }
}
