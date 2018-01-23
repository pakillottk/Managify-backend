<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\UserTransformer;

class FormatUserToJsonJob extends Job
{
    private $user;
    private $transformer;
    private $query;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $user, $query = null )
    {
        $this->user = $user;
        $this->transformer = new UserTransformer();
        $this->query = $query;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->transformer->transform( $this->user, $this->query );
    }
}
