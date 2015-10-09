<?php

namespace FastNorth\Validator;

use FastNorth\Validator\Definition\Field as FieldDefinition;

/**
 * Definition.
 *
 * Validation definition
 */
class Definition implements DefinitionInterface
{
    /**
     * Fields without a "when" clause.
     *
     * @var FieldDefinition[]
     */
    private $fields = [];

    /**
     * Fields with a "when" clause.
     *
     * hash of field name => [['when' => callable, 'definition' => FieldDefinition]]
     *
     * @var array
     */
    private $fieldsWithWhen = [];

    /**
     * {@inheritdoc}
     */
    public function field($field, callable $when = null)
    {
        if ($when === null) {
            if (!isset($this->fields[$field])) {
                $this->fields[$field] = new FieldDefinition($field);
            }

            return $this->fields[$field];
        }

        $definition = new FieldDefinition($field);
        $this->fieldsWithWhen[$field][] = [
            'when'       => $when,
            'definition' => $definition,
        ];

        return $definition;
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return array_merge(
            array_keys($this->fields),
            array_keys($this->fieldsWithWhen)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraints($field, $value, $context)
    {
        $constraints = [];
        foreach ($this->getFieldDefinitions($field, $value, $context) as $fieldDefinition) {
            $constraints = array_merge($constraints, $fieldDefinition->getConstraints($value, $context));
        }

        return $constraints;
    }

    /**
     * Get the field definitions for a field based on value/context.
     *
     * @param string $field
     * @param mixed  $value
     * @param mixed  $context
     *
     * @return FieldDefinition[]
     */
    private function getFieldDefinitions($field, $value, $context)
    {
        // Sanity check field actually exists
        if (!isset($this->fields[$field]) && !isset($this->fieldsWithWhen[$field])) {
            throw new \RuntimeException(sprintf(
                'Field "%s" does not exist',
                $field
            ));
        }

        $fields = [];

        // Regular fields, always added
        if (isset($this->fields[$field])) {
            $fields[] = $this->fields[$field];
        }

        // Closure based field definitions, need to match closure
        if (isset($this->fieldsWithWhen[$field])) {
            foreach ($this->fieldsWithWhen[$field] as $match) {
                if ($match['when']($value, $context)) {
                    $fields[] = $match['definition'];
                }
            }
        }

        return $fields;
    }
}
