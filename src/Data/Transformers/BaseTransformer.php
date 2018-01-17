<?php

namespace App\Data\Transformers;

abstract class BaseTransformer {
    abstract public function transform( $data, $toHide = [] );

    protected function hideFields( $data, $toHide ) {
        foreach( $toHide as $fieldToHide ) {
            unset( $data[ $fieldToHide ] );
        }
        
        return $data;
    }
}