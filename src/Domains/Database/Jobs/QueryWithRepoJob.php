<?php
namespace App\Domains\Database\Jobs;

use Lucid\Foundation\Job;

class QueryWithRepoJob extends Job
{
    private $repo;
    private $query;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $repo, $query = [] )
    {
        $this->repo = $repo;
        $this->query = $query;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if( empty( $this->query ) ) {
            return $this->repo->all();
        }
        
        return $this->repo->getByAttributes( $this->query );
    }
}
