<?php
namespace App\Domains\Database\Jobs;

use Lucid\Foundation\Job;
use Illuminate\Database\Eloquent\Model;
use App\Data\Queries\Query;
use App\Data\Queries\Runners\EloquentQueryRunner;

class BuildEloquentQueryRunnerJob extends Job
{
    private $query;
    private $model;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Query $query, Model $model )
    {
        $this->query = $query;
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return new EloquentQueryRunner( $this->query, $this->model );
    }
}
