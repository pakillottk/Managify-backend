<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;

class FormatCompanyToJsonJob extends Job
{
    private $company;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $company )
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return [
            'id' => (int) $this->company->id,
            'nif' => (string) $this->company->nif,
            'name' => (string) $this->company->name,
            'email' => (string) $this->company->email,
            'address' => $this->company->address !== null ? ( (string)$this->company->address ) : null,
            'phone' => $this->company->phone !== null ? ( (string)$this->company->phone ) : null,
            'logo_url' => $this->company->logo_url !== null ? ( (string)$this->company->logo_url ) : null
        ]; 
    }
}
