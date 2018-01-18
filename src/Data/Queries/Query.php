<?php

namespace App\Data\Queries;

class Query {
    protected $select = [];
    protected $hidden = [];
    protected $fields = [];

    public function __construct( $select = [], $hidden = [], $fields = [] ) {
        $this->select = $select;
        $this->hidden = $hidden;
        $this->fields = $fields;
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
}