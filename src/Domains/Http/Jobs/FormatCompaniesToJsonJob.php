<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\CompanyTransformer;

class FormatCompaniesToJsonJob extends Job
{
    private $companies;
    private $transformer;
    private $query;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $companies, $query = null )
    {
        $this->companies = $companies;
        $this->transformer = new CompanyTransformer();
        $this->query = $query;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        return $this->transformer->transform( $this->companies, $this->query );
    }
}
