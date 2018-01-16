<?php
namespace App\Services\Api\Features;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

use App\Domains\User\Jobs\ValidateInputForCompanyJob;
use App\Domains\Database\Jobs\CreateCompanyJob;
use App\Domains\Database\Jobs\SaveModelJob;

use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use App\Data\Repositories\CompanyRepository;
use Exception;

class CreateCompanyFeature extends Feature
{
    public function handle(Request $request, CompanyRepository $repo )
    {
        $validatedInput = null;
        try {
            $validatedInput = $this->run( ValidateInputForCompanyJob::class, [
                'input' => $request->input()
            ]);
            
            $company = $this->run( CreateCompanyJob::class, [
                'repo' => $repo,
                'data' => $validatedInput
            ]);

            $company = $this->run( SaveModelJob::class, [
                'model' => $company
            ]);

            return $this->run( new RespondWithJsonJob( $company ) );            
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }        
    }
}
