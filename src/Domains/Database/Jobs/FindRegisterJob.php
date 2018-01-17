<?php
namespace App\Domains\Database\Jobs;

use Lucid\Foundation\Job;

class FindRegisterJob extends Job
{
    private $repo;
    private $field;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $repo, $field )
    {
        $this->repo = $repo;
        $this->field = $field;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->repo->findBy( $this->field["name"], $this->field["value"] );
    }
}
