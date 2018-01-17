<?php
namespace App\Domains\Database\Jobs;

use Lucid\Foundation\Job;
use Exception;

class CreateModelInstanceJob extends Job
{
    private $namespace;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $namespace )
    {
        $this->namespace = $namespace;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $model = null;
        if( class_exists( $this->namespace ) ) {           
            $model = new $this->namespace;         
            if( $model instanceof \Illuminate\Database\Eloquent\Model  ) {
                return $model;
            }    
        }

        throw new Exception( 'The given namespace is not a Model.' );
    }
}
