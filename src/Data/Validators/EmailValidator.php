<?php

namespace App\Data\Validators;

use App\Data\Validators\BaseValidator;

class EmailValidator extends BaseValidator {
    public function validate( $email ) {
        return filter_var( $email, FILTER_VALIDATE_EMAIL );
    }
}