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
    public function __construct( $repo, $query = null )
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
        return $this->repo->getByQuery( $this->query );
    }
}
