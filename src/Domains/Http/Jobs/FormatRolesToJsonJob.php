<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\RoleTransformer;

class FormatRolesToJsonJob extends Job
{
    private $roles;
    private $transformer;
    private $query;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $roles, $query = null )
    {
        $this->roles = $roles;
        $this->transformer = new RoleTransformer();
        $this->query = $query;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->transformer->transform( $this->roles, $this->query );
    }
}
