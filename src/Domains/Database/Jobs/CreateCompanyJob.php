<?php
namespace App\Domains\Database\Jobs;

use Lucid\Foundation\Job;

class CreateCompanyJob extends Job
{
    private $data;
    private $repo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $repo, $data )
    {
        $this->repo = $repo;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->repo->fill( $this->data );
    }
}
