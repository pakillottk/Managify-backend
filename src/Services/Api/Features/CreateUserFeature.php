<?php
namespace App\Services\Api\Features;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

//Database related
use App\Domains\Database\Jobs\GetModelRepositoryJob;
use App\Domains\Database\Jobs\CreateModelInstanceJob;
use App\Domains\Database\Jobs\FillWithRepoJob;
use App\Domains\Database\Jobs\SaveModelJob;

//Specific
use App\Domains\User\Jobs\ValidateInputForUserJob;
use App\Domains\Http\Jobs\FormatUserToJsonJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class CreateUserFeature extends Feature
{
    public function handle(Request $request)
    {
        try {            
            $validatedInput = $this->run( ValidateInputForUserJob::class, [
                'input' => $request->input()
            ]);            
            $user = $this->run( CreateModelInstanceJob::class, [
                'namespace' => '\Framework\User' 
            ]);

            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => $user
            ]);
            
            $user = $this->run( FillWithRepoJob::class, [
                'repo' => $repo,
                'data' => $validatedInput
            ]);
            $user = $this->run( SaveModelJob::class, [
                'model' => $user
            ]);

            $user = $this->run( FormatUserToJsonJob::class,[
                'user' => $user
            ]);
            
            return $this->run( new RespondWithJsonJob( $user ) );            
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        } 
    }
}
