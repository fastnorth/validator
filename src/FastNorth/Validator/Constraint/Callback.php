<?php

namespace FastNorth\Validator\Constraint;

/**
 * Callback
 *
 * Runs callback to validate
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
        if (! $callback($value, $context)) {
            return $this->fail(self::INVALID);
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
            self::INVALID => 'Invalid value'
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
