<?php

namespace App\Data\Repositories;

use Framework\Company;

/**
 * Base Repository.
 */
class CompanyRepository extends Repository
{
    /**
     * The model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public function __construct( Company $model )
    {
        parent::__construct( $model );
    }
}
