<?php
namespace App\Domains\Database\Jobs;

use App\Data\Repositories\Repository;
use Lucid\Foundation\Job;

class GetModelRepositoryJob extends Job
{
    private $model;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $model )
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return new Repository( $this->model );
    }
}
