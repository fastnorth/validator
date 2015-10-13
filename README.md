# FastNorth Validator

[![Build Status](https://travis-ci.org/fastnorth/validator.svg)](https://travis-ci.org/fastnorth/validator)

This is a simple data validation library that deals with validating a variety of data structures. It was born out of dissatisfaction with existing libraries that were either very complex and hard to implement, or seemed to have design flaws.

## Installation

Simply install through [Composer](http://getcomposer.org/):

`composer require fastnorth/validator`

## Usage

Validating data is a two part process:

 * Defining what your data should look like by defining constraints
 * Validating that a dataset matches the constraints

The first step is done by creating a [Definition](https://github.com/fastnorth/validator/blob/master/src/FastNorth/Validator/Definition.php), the second by running the data and definition through a [Validator](https://github.com/fastnorth/validator/blob/master/src/FastNorth/Validator/Validator.php).

### Definitions

Definitions are specified through a "field" basis. A field can be anything that can be access through [Symfony's PropertyAccess Component](http://symfony.com/doc/current/components/property_access/introduction.html).

You can either extend [Definition](https://github.com/fastnorth/validator/blob/master/src/FastNorth/Validator/Definition.php) or define the constraints on an instance of it:

```php
<?php
use FastNorth\Validator\Definition;

$definition = new Definition;

$definition

    // Validate [foo] has a minimum string length of 10 characters
    ->field('[foo]')
    ->should(new Constraint\StringLength(['min' => 10]))

    // [bar] has to exist
    ->field('[bar]')
    ->required();
```

### Validating

Validation uses the [Validator](https://github.com/fastnorth/validator/blob/master/src/FastNorth/Validator/Validator.php) class. It takes a [Definition](https://github.com/fastnorth/validator/blob/master/src/FastNorth/Validator/Definition.php) instance in its constructor, and has a `validate()` method to validate any data to match the definition. This method returns a [Validation](https://github.com/fastnorth/validator/blob/master/src/FastNorth/Validator/Validation.php) instance.

```php
<?php

use FastNorth\Validator\Definition;
$validator = new Validator($definition);

// $yourData = ...;

$validation = $validator->validate($yourData);

if ($validation->passes()) {
    // Data matched definition
} else {
    // Validation messages are returned as an array per field
    foreach($validation->getMessages() as $field => $messagesPerField) {
        foreach($messagesPerField as $message) {
            echo $message;
        }
    }
}

```
