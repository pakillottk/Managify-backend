<?php

namespace App\Data\Queries\Runners;

use Illuminate\Database\Eloquent\Model;
use App\Data\Queries\Query;

class EloquentQueryRunner extends QueryRunner {
    private $model;

    public function __construct( Query $query, Model $model ) {
        parent::__construct( $query );

        $this->model = $model;
    }

    public function run() {
        $query = $this->query;
        
        $output =   $this->model
                    ->where( $query->getSelect() );
        
        $aggregations = $query->getAggregate();
        if( !empty( $aggregations ) ) {
            $aggregationResults = [];
            foreach( $aggregations as $operation => $field ) {
                $result = null;
                if( empty( $field ) ) {
                    $result = $output->$operation();
                } else {
                    $result = $output->$operation($field);
                }

                $aggregationResults[ $operation.'('.$field.')' ] = $result;
            }
       
            return $aggregationResults;
        }
                    
        return $output  ->orderBy( $query->getOrderBy(), $query->getSorting() )
                        ->with( $query->getInclude() )
                        ->take( 10 )
                        ->skip( $query->getPage() )
                        ->get();  
    }
}