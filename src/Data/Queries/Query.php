<?php

namespace App\Data\Queries;

class Query {
    protected $select = [];
    protected $hidden = [];
    protected $fields = [];
    protected $include = [];
    protected $page = 0;
    protected $orderBy = 'updated_at';
    protected $sorting = 'desc';

    public function __construct( 
        $select = [], $hidden = [], $fields = [], $include = [], 
        $page = 0, $orderBy = 'updated_at', $sorting = 'desc' 
    ) {
        $this->select = $select;
        $this->hidden = $hidden;
        $this->fields = $fields;
        $this->include = $include;
        $this->page = $page;
        $this->orderBy = $orderBy;
        $this->sorting = $sorting;
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
}