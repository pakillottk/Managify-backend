<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\RoleTransformer;

class FormatRoleToJsonJob extends Job
{
    private $role;
    private $transformer;
    private $toHide;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $role, $toHide = [] )
    {
        $this->role = $role;
        $this->transformer = new RoleTransformer();
        $this->toHide = $toHide;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->transformer->transform( $this->role, $this->toHide  );
    }
}
