<?php

namespace FastNorth\Validator;

use FastNorth\Validator\Definition;
use Symfony\Component\Validator\Constraints;

/**
 * Example
 *
 * Example validation definition
 */
class Example extends Definition
{
    public function __construct()
    {
        // Simple validation chain, per field
        $this
            ->field('foo')
            ->should(new Constraints\NotNull)
            ->should(new Constraints\Length(['max' => 255]));
    }
}
