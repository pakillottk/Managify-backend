<?php
namespace App\Services\Api\Features;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

//Database related
use App\Domains\Database\Jobs\GetModelRepositoryJob;
use App\Domains\Database\Jobs\CreateModelInstanceJob;
use App\Domains\Database\Jobs\FindRegisterJob;
use App\Domains\Database\Jobs\FillWithRepoJob;
use App\Domains\Database\Jobs\SaveModelJob;

//Specific
use App\Domains\User\Jobs\ValidateInputForCompanyJob;
use App\Domains\Http\Jobs\FormatCompanyToJsonJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

class UpdateCompanyFeature extends Feature
{
    private $id;

    public function __construct( $id ) {
        $this->id = (int) $id;
    }

    public function handle( Request $request )
    {
        try {
            $validatedInput = $this->run( ValidateInputForCompanyJob::class, [
                'input' => $request->input()
            ]);

            $company = $this->run( CreateModelInstanceJob::class, [
                'namespace' => '\Framework\Company' 
            ]);
            
            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => $company
            ]);

            $company = $this->run( FindRegisterJob::class, [
                'repo' => $repo,
                'field' => [
                    'name' => 'id',
                    'value' => $this->id
                ]
            ]);            
                
            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => $company
            ]);

            $company = $this->run( FillWithRepoJob::class, [
                'repo' => $repo,
                'data' => $validatedInput
            ]);
            
            $company = $this->run( SaveModelJob::class, [
                'model' => $company
            ]);

            $company = $this->run( FormatCompanyToJsonJob::class, [
                'company' => $company
            ]);

            return $this->run( new RespondWithJsonJob( $company ) ); 
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }
    }
}
