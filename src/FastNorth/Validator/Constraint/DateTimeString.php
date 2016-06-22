<?php

namespace FastNorth\Validator\Constraint;

/**
 * DateTimeString
 *
 * Must be a valid date and time string
 */
class DateTimeString extends AbstractConstraint
{
    const INCORRECT_VALUE = 'invalid';
    const EMPTY_VALUE = 'missing';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        if (empty($value)) {
            return $this->fail(self::EMPTY_VALUE);
        }

        if (!strtotime($value)) {
            // is this string valid?
            return $this->fail(self::INCORRECT_VALUE);
        }

        $timeStamp = strtotime($value);
        if (!checkdate(date('m', $timeStamp), date('d', $timeStamp), date('Y', $timeStamp))) {
            // does this string represent an actual date?
            return $this->fail(self::INCORRECT_VALUE);
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
            self::EMPTY_VALUE => 'This field should not be empty',
            self::INCORRECT_VALUE => 'This field is not a valid date time string'
        ];
    }
}
