<?php

namespace App\Data\Validators;

abstract class BaseValidator {
    abstract public function validate( $input );
}