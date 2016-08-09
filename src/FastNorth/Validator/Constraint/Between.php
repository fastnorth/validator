<?php
namespace FastNorth\Validator\Constraint;

/**
 * Between
 *
 * Checks the value is between a min and max
 */
class Between extends AbstractConstraint
{
    const TOO_LOW = 'value_too_low';
    const TOO_HIGH  = 'value_too_high';
    const EMPTY_VALUE = 'missing';

    /**
     * @inheritDoc
     */
    public function validate($value, $context = null)
    {
        if (is_null($value)) {
            return $this->fail(self::EMPTY_VALUE);
        }

        $min = $this->getOption('min');
        if ($min >= 0 && strlen($value) < $min) {
            return $this->fail(self::TOO_LOW, $this->getOptions());
        }

        $max = $this->getOption('max');
        if ($max >= 0 && strlen($value) > $max) {
            return $this->fail(self::TOO_HIGH, $this->getOptions());
        }

        return $this->pass();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultMessages()
    {
        return [
             self::TOO_LOW => 'The value you have provided must be greater than or equal to {{ min }} characters',
             self::TOO_HIGH  => 'The value you have provided must be less than or equal to {{ max }} characters'
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
