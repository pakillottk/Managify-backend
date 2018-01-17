<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;

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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if( empty( $this->params ) ) {
            return $this->request->query();
        }

        return $this->request->query( $this->params );
    }
}
