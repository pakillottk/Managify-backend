<?php
namespace App\Domains\Database\Jobs;

use Lucid\Foundation\Job;

class RemoveFromRepoJob extends Job
{
    private $repo;
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $repo, $id )
    {
        $this->repo = $repo;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->repo->remove( $this->id );
    }
}
