<?php

namespace FastNorth\Validator;

use FastNorth\Validator\Validation\Compound as CompoundValidation;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Validator.
 *
 * Validator validates
 */
class Validator implements ValidatorInterface
{
    /**
     * the definition.
     *
     * @var DefinitionInterface
     */
    private $definition;

    /**
     * the property accessor.
     *
     * @var PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * Constructor.
     *
     * @param DefinitionInterface $definition
     */
    public function __construct(DefinitionInterface $definition)
    {
        $this
            ->setDefinition($definition)
            ->setPropertyAccessor(PropertyAccess::createPropertyAccessor());
    }

    /**
     * {@inheritdoc}
     */
    public function validate($data)
    {
        $fullValidation = new CompoundValidation;

        foreach ($this->getDefinition()->getFields() as $field) {
            // Validate the field and add to full validation
            $fullValidation->add($field, $this->validateField($field, $data));
        }

        return $fullValidation;
    }

    /**
     * @inheritdoc
     */
    public function validateField($field, $data)
    {
        // Retrieve field's value
        $value = $this->getFieldValue($field, $data);

        // Constraints
        $constraints = $this->getDefinition()->getConstraints($field, $value, $data);

        // Combine field validations
        $combinedFieldValidation = new CompoundValidation($field);
        foreach ($constraints as $key => $validator) {
            /** @var ValidatorInterface $validator */

            $combinedFieldValidation->add(
                $field . '-' . $key,
                $validator->validate($value, $data)
            );
        }

        return $combinedFieldValidation;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue($field, $data)
    {
        if ($data === null) {
            throw new \RuntimeException('There is no field data to access, call validate() first');
        }

        if (is_array($data)) {
            if ($field[0] !== '[') {
                $field = "[$field]";
            }
        }

        return $this->getPropertyAccessor()->getValue($data, $field);
    }

    /**
     * Get the definition.
     *
     * @return DefinitionInterface
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Set the definition.
     *
     * @param DefinitionInterface $definition
     *
     * @return self
     */
    public function setDefinition(DefinitionInterface $definition)
    {
        $this->definition = $definition;

        return $this;
    }

    /**
     * Get the property accessor.
     *
     * @return PropertyAccessor
     */
    public function getPropertyAccessor()
    {
        return $this->propertyAccessor;
    }

    /**
     * Set the property accessor.
     *
     * @param PropertyAccessor $propertyAccessor
     *
     * @return self
     */
    public function setPropertyAccessor(PropertyAccessor $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;

        return $this;
    }
}
