<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\CompanyTransformer;

class FormatCompanyToJsonJob extends Job
{
    private $company;
    private $transformer;
    private $query;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $company, $query = null )
    {
        $this->company = $company;
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
        return $this->transformer->transform( $this->company, $this->query  );
    }
}
