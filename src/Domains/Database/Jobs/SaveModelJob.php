<?php
namespace App\Domains\Database\Jobs;

use Lucid\Foundation\Job;

class SaveModelJob extends Job
{
    protected $model;
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
        $this->model->save();
        return $this->model;
    }
}
