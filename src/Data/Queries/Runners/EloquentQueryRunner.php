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

    protected function runSelect( $output, $select ) {
        if( !empty( $select ) ) {
            foreach( $select as $whereClause ) {
                $output = $output->where( 
                            $whereClause[ 'field' ], 
                            $whereClause[ 'operator' ], 
                            $whereClause[ 'value' ] 
                        );
            }
        }

        return $output;
    }

    protected function runAggregations( $output, $aggregations ) {
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

    protected function runOrderBy( $output, $query ) {
        if( !empty( $orderBy ) ) {
            foreach( $orderBy as $orderData ) {
                $output = $output->orderBy( $orderData[ 'field' ], $orderData[ 'sorting' ] );
            }
        }

        return $output;
    }

    public function run() {
        $query  = $this->query;
        $output = $this->model;

        $output             = $this->runSelect( $output, $query->getSelect() );
        $aggregationResults = $this->runAggregations( $output, $query->getAggregate() );
        if( !empty( $aggregationResults ) ) {
            return $aggregationResults;
        }
        $output             = $this->runOrderBy( $output, $query->getOrderBy() );
                           
        return $output  ->with( $query->getInclude() )
                        ->take( 10 )
                        ->skip( $query->getPage() )
                        ->get();  
    }
}