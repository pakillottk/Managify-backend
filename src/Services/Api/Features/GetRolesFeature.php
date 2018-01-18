<?php
namespace App\Services\Api\Features;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

//Http related
use App\Domains\Http\Jobs\ExtractQueryParametersJob;

//Database related
use App\Domains\Database\Jobs\GetModelRepositoryJob;
use App\Domains\Database\Jobs\CreateModelInstanceJob;
use App\Domains\Database\Jobs\QueryWithRepoJob;

//Specific
use App\Domains\Http\Jobs\FormatRolesToJsonJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class GetRolesFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            $query = $this->run( ExtractQueryParametersJob::class, [
                'request' => $request
            ]);            
            $role = $this->run( CreateModelInstanceJob::class, [
                'namespace' => '\Framework\Role'
            ]);
            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => $role
            ]);
            $roles = $this->run( QueryWithRepoJob::class, [
                'repo' => $repo,
                'query'=> $query
            ]);
            $roles = $this->run( FormatRolesToJsonJob::class, [
                'roles' => $roles,
                'query' => $query
            ]);

            return $this->run( new RespondWithJsonJob( $roles ) );       
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }
    }
}
