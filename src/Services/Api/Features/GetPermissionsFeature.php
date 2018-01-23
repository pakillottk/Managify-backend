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
use App\Domains\Http\Jobs\FormatPermissionToJsonJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class GetPermissionsFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            $query = $this->run( ExtractQueryParametersJob::class, [
                'request' => $request
            ]);            
            $permission = $this->run( CreateModelInstanceJob::class, [
                'namespace' => '\Framework\Permission'
            ]);
            $runner = $this->run( BuildEloquentQueryRunnerJob::class, [
                'query' => $query,
                'model' => $permission
            ]);
            $permissions = $this->run( RunQueryRunnerJob::class, [
                'runner' => $runner 
            ]);
            $permissions = $this->run( FormatPermissionToJsonJob::class, [
                'permission' => $permissions,
                'query' => $query
            ]);

            return $this->run( new RespondWithJsonJob( $permissions ) );       
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }
    }
}
