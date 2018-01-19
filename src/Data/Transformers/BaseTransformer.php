<?php

namespace App\Data\Transformers;

use App\Data\Queries\Query;

abstract class BaseTransformer {
    abstract protected function _transform( $data, ?Query $query );

    abstract protected function getRelationTransformer( $relation );

    private function getItemTransformed( $data, $query ) {
        $output = $this->_transform( $data, $query );
        $output = $this->includeRelations( $output, $data, $query );        
        return $this->hideFields( $output, $query );
    }

    public function transform( $data, ?Query $query ) {
        if( $query !== null ) {
            if( !empty( $query->getAggregate() ) ) {
                return $data;
            }
        }
        
        $output = [];
        if ( 
            $data instanceof \Illuminate\Database\Eloquent\Collection ||
            is_array( $data )    
        ) {            
            foreach( $data as $item ) {
                array_push( $output, $this->getItemTransformed( $item, $query ) );
            }

            return $output;
        }
        
        return $this->getItemTransformed( $data, $query );
    }

    protected function includeRelations( $output, $data, ?Query $query ) {
        if( $query !== null ) {
            foreach( $query->getInclude() as $relation ) {
                $relationData = $data[ $relation ];
                $transformer = $this->getRelationTransformer( $relation );

                if( $transformer !== null ) {
                    $output[ $relation ] = $transformer->transform( $relationData, null );
                }
            }
        }

        return $output;
    }

    protected function hideFields( $data, ?Query $query ) {
        if( $query === null ) {
            return $data;
        }
        
        $output = [];
        $toShow = $query->getFields();
        $toHide = $query->getHidden();
        foreach( $data as $key => $value ) {
            if( !empty( $toShow ) ) {
                if( !isset( $toShow[ $key ] ) ) {
                    continue;
                }
            }
            
            if( !isset( $toHide[ $key ] ) ) {
                $output[ $key ] = $value;
            }
        }

        return $output;
    }
}