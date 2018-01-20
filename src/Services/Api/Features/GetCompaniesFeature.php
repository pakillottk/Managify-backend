<?php
namespace App\Services\Api\Features;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

//Http related
use App\Domains\Http\Jobs\ExtractQueryParametersJob;

//Database related
use App\Domains\Database\Jobs\GetModelRepositoryJob;
use App\Domains\Database\Jobs\CreateModelInstanceJob;
use App\Domains\Database\Jobs\BuildEloquentQueryRunnerJob;
use App\Domains\Database\Jobs\RunQueryRunnerJob;

//Specific
use App\Domains\Http\Jobs\FormatCompaniesToJsonJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class GetCompaniesFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            $query = $this->run( ExtractQueryParametersJob::class, [
                'request' => $request
            ]);            
            $company = $this->run( CreateModelInstanceJob::class, [
                'namespace' => '\Framework\Company'
            ]);
            $runner = $this->run( BuildEloquentQueryRunnerJob::class, [
                'query' => $query,
                'model' => $company
            ]);
            $companies = $this->run( RunQueryRunnerJob::class, [
                'runner' => $runner 
            ]);
            $companies = $this->run( FormatCompaniesToJsonJob::class, [
                'companies' => $companies,
                'query' => $query
            ]);

            return $this->run( new RespondWithJsonJob( $companies ) );       
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }
    }
}
