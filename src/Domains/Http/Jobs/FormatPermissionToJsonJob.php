<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\PermissionTransformer;

class FormatPermissionToJsonJob extends Job
{
    private $transformer;
    private $permission;
    private $query;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $permission, $query = null )
    {
        $this->permission = $permission;
        $this->transformer = new PermissionTransformer();
        $this->query = $query;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->transformer->transform( $this->permission, $this->query );
    }
}
