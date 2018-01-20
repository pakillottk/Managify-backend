<?php
namespace App\Domains\Database\Jobs;

use Lucid\Foundation\Job;
use App\Data\Queries\Runners\QueryRunner;

class RunQueryRunnerJob extends Job
{
    private $runner;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( QueryRunner $runner )
    {
        $this->runner = $runner;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->runner->run();
    }
}
