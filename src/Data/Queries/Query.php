<?php

namespace App\Data\Queries;

class Query {
    //Format: [ [ field => ... , operator => ... , value => ...  ], ... ]
    //Result: The WHERE fragment of the select will have these configuration
    protected $select = [];
    //Format: [ field1, field2... ]
    //Result: The specified fields won't be returned
    protected $hidden = [];
    //Format: [ field1, field2... ]
    //Result: Only the specified fields will be returned
    protected $fields = [];
    //Format: [ relation1, relation2... ]
    //Result: Adds the specified relationship to the results
    protected $include = [];
    //Format: any int [0-MAX_INT]
    //Result: Sets the current page of the query
    protected $page = 0;
    //Format: [ [ field => ... , sorting => desc|asc ], ... ]
    //Result: Sets the order of the query results
    protected $orderBy;
    //Format: [ operation => field, ... ]
    //Result: Gets the results of the specified operation on the selected field (affected by select clauses) 
    protected $aggregate = [];

    public function __construct( 
        $select = [], $hidden = [], $fields = [], $include = [], 
        $page = 0, $orderBy = [ 'field' => 'updated_at', 'sorting' => 'desc' ], $aggregate = [] 
    ) {
        $this->select = $select;
        $this->hidden = $hidden;
        $this->fields = $fields;
        $this->include = $include;
        $this->page = $page;
        $this->orderBy = $orderBy;
        $this->aggregate = $aggregate;
    }

    public function getFields() {
        return $this->fields;
    }

    public function getHidden() {
        return $this->hidden;
    }

    public function getSelect() {
        return $this->select;
    }

    public function getInclude() {
        return $this->include;
    }

    public function getPage() {
        return $this->page;
    }

    public function getOrderBy() {
        return $this->orderBy;
    }

    public function getSorting() {
        return $this->sorting;
    }

    public function getAggregate() {
        return $this->aggregate;
    }
}