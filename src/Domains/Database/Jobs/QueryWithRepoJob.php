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
        if( $this->query === null ) {
            return $this->repo->all();
        }

        $page = $this->query->getPage();
        $select = $this->query->getSelect();
        if( empty( $select ) ) {
            return $this->repo->page( 10, $page ,$this->query->getInclude() );
        }
        return $this->repo->getByAttributes( $select, 'AND', $this->query->getInclude() );
    }
}
