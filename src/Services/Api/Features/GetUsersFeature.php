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
use App\Domains\Http\Jobs\FormatUserToJsonJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class GetUsersFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            $query = $this->run( ExtractQueryParametersJob::class, [
                'request' => $request
            ]);            
            $user = $this->run( CreateModelInstanceJob::class, [
                'namespace' => '\Framework\User'
            ]);
            $runner = $this->run( BuildEloquentQueryRunnerJob::class, [
                'query' => $query,
                'model' => $user
            ]);
            $users = $this->run( RunQueryRunnerJob::class, [
                'runner' => $runner 
            ]);
            $users = $this->run( FormatUserToJsonJob::class, [
                'user' => $users,
                'query' => $query
            ]);

            return $this->run( new RespondWithJsonJob( $users ) );       
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }
    }
}
