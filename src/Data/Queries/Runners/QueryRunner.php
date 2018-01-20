<?php

namespace App\Data\Queries\Runners;

use App\Data\Queries\Query;

abstract class QueryRunner {
    protected $query;   
    
    public function __construct( Query $query ) {
        $this->query = $query;
    }

    abstract public function run();
}
