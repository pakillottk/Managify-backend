<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\RoleTransformer;

class FormatRoleToJsonJob extends Job
{
    private $role;
    private $transformer;
    private $query;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $role, $query = null )
    {
        $this->role = $role;
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
        return $this->transformer->transform( $this->role, $this->query  );
    }
}
