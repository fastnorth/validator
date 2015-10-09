<?php

namespace FastNorth\Validator\Constraint;

/**
 * StringLength
 *
 * String length constraint
 */
class StringLength extends AbstractConstraint
{
    const TOO_SHORT = 'string_too_short';
    const TOO_LONG  = 'string_too_long';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        $min = $this->getOption('min');
        if ($min >= 0 && strlen($value) < $min) {
            return $this->fail(self::TOO_SHORT);
        }

        $max = $this->getOption('max');
        if ($max >= 0 && strlen($value) > $max) {
            return $this->fail(self::TOO_LONG);
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
            self::TOO_SHORT => 'The value you have provided is shorter than the required {{ min }} characters',
            self::TOO_LONG  => 'The value you have provided is longer than the maximum {{ min }} characters'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultOptions()
    {
        return [
            'min' => -1,
            'max' => -1
        ];
    }
}
