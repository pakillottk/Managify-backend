<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;

use App\Data\Queries\Query;
use Exception;

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
            preg_match_all( '/[a-z A-Z 0-9 _]+[=]{1}[\s a-z A-Z 0-9]+/', $params[ 'select' ], $matches );
          
            foreach( $matches[0] as $clause){
                $splittedByEquals = explode( '=', $clause ); 
                $output[ $splittedByEquals[ 0 ] ] = $splittedByEquals[ 1 ];
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

    /**
     * Execute the job.
     *
     * @return Query
     */
    public function handle()
    {
        $params = $this->getQueryParameters();

        $page       = $this->extractPage( $params );
        $select     = $this->extractSelect( $params );
        $hidden     = $this->extractHidden( $params );
        $fields     = $this->extractFields( $params );
        $include    = $this->extractInclude( $params );    

        return new Query( $select, $hidden, $fields, $include, $page );
    }
}
