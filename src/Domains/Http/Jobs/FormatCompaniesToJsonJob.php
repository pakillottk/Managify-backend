<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\CompanyTransformer;

class FormatCompaniesToJsonJob extends Job
{
    private $companies;
    private $transformer;
    private $toHide = [];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $companies, $toHide = [] )
    {
        $this->companies = $companies;
        $this->transformer = new CompanyTransformer();
        $this->toHide = $toHide;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $output = [];
        foreach( $this->companies as $company ) {
            array_push( $output, $this->transformer->transform( $company, $this->toHide ) );
        }

        return $output;
    }
}
