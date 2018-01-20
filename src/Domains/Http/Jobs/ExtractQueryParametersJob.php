<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Queries\Query;

class ExtractQueryParametersJob extends Job
{
    private $request;
    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $request, $params = [] )
    {
        $this->request = $request;
        $this->params = $params;
    }

    private function getQueryParameters() {
        if( empty( $this->params ) ) {
            return $this->request->query();
        }

        return $this->request->query( $this->params );
    }

    private function extractPage( $params ) {
        if( isset( $params[ 'page' ] ) ) {
            return (int)$params[ 'page' ];
        }

        return 0;
    }

    private function extractFields( $params ) {
        $output = [];
        $matches = [];
        if( isset( $params[ 'fields' ] ) ) {
            preg_match_all( '/[a-zA-Z0-9_]+/', $params[ 'fields' ], $matches );
            foreach( $matches[0] as $field){
                $output[ $field ] = '';
            }
        }        

        return $output;
    }

    
    private function extractSelect( $params ) {
        $output = [];
        $matches = [];
        if( isset( $params[ 'select' ] ) ) {
            preg_match_all( '/[a-z A-Z 0-9 _]+(>=|<=|=|<>|<|>){1}[\s a-z A-Z 0-9]+/', $params[ 'select' ], $matches );
            for( $i = 0; $i < count( $matches[0] ); $i++ ){
                $clause = $matches[ 0 ][ $i ];
                $operator = $matches[ 1 ][ $i ];
                $splitted = explode( $operator, $clause ); 
                if( $splitted[ 1 ] === 'null' ) {
                    $splitted[ 1 ] = null;
                }
                
                array_push( $output, [
                    'field' => $splitted[ 0 ],
                    'operator' => $operator,
                    'value' => $splitted[ 1 ]
                ]);
            }
        }

        return $output;
    }

    private function extractHidden( $params ) {
        $output = [];
        $matches = [];
        if( isset( $params[ 'hidden' ] ) ) {
            preg_match_all( '/[a-zA-Z0-9_]+/', $params[ 'hidden' ], $matches );
            foreach( $matches[0] as $field){
                $output[ $field ] = '';
            }
        }        

        return $output;
    }

    private function extractInclude( $params ) {
        $output = [];
        $matches = [];
        if( isset( $params[ 'include' ] ) ) {
            preg_match_all( '/[a-zA-Z0-9_]+/', $params[ 'include' ], $matches );
            foreach( $matches[0] as $relation){
                array_push( $output, $relation );
            }
        }        

        return $output;
    }

    private function extractOrder( $params ) {
        $order = [];
        $matches = [];

        if( isset( $params[ 'order' ] ) ) {
            preg_match_all( '/[a-z A-Z 0-9_]+[|](desc|asc)/', $params[ 'order' ], $matches );
            if( !empty( $matches[ 0 ] ) ) {
                $orderData = $matches[ 0 ];
                foreach( $matches[0] as $orderData ) {
                    $splittedData = explode( '|', $orderData );

                    array_push( $order, [
                        'field' => $splittedData[ 0 ],
                        'sorting' => $splittedData[ 1 ]
                    ]);
                }
            }
        }

        return $order;
    }

    private function extractAggregate( $params ) {
        $output = [];
        $matches = [];

        if( isset( $params[ 'aggregate' ] ) ) {
            preg_match_all( 
                '/((max|min|avg|count){1}[(][a-z A-Z 0-9 _]*[)])/',
                $params[ 'aggregate' ],
                $matches
            );

            if( !empty( $matches )  ) {
                $results = $matches[ 0 ];
                foreach( $results as $toAggregate ) {
                    $operation = [];
                    preg_match( '/(max|min|avg|count){1}/', $toAggregate, $operation );
                    $operation = $operation[ 0 ];

                    $field = [];
                    preg_match( '/[(][a-z A-Z 0-9 _]*[)]/', $toAggregate, $field );
                    $field = $field[ 0 ];
                    $field = str_replace( ['(', ')'], '', $field );
                    
                    $output[ $operation ] = $field;
                }
            }
        }
        
        return $output;
    }

    private function buildQuery( $params ) {
        $page       = $this->extractPage( $params );
        $select     = $this->extractSelect( $params );
        $hidden     = $this->extractHidden( $params );
        $fields     = $this->extractFields( $params );
        $include    = $this->extractInclude( $params );
        $order      = $this->extractOrder( $params );    
        $aggregate  = $this->extractAggregate( $params );

        return new Query( 
            $select, 
            $hidden, 
            $fields, 
            $include, 
            $page, 
            $order, 
            $aggregate
        );
    }

    /**
     * Execute the job.
     *
     * @return Query
     */
    public function handle()
    {
        $params = $this->getQueryParameters();
        return $this->buildQuery( $params );       
    }
}
