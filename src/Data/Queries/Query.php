<?php

namespace App\Data\Queries;

class Query {
    protected $select = [];
    protected $hidden = [];
    protected $fields = [];
    protected $include = [];
    protected $page = 0;

    public function __construct( $select = [], $hidden = [], $fields = [], $include = [], $page = 0 ) {
        $this->select = $select;
        $this->hidden = $hidden;
        $this->fields = $fields;
        $this->include = $include;
        $this->page = $page;
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
}