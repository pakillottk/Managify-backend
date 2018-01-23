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
use App\Domains\User\Jobs\ValidateInputForPermissionJob;
use App\Domains\Http\Jobs\FormatPermissionToJsonJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class UpdatePermissionFeature extends Feature
{
    private $id;

    public function __construct( $id ) {
        $this->id = $id;
    }

    public function handle(Request $request)
    {
        try {
            $validatedInput = $this->run( ValidateInputForPermissionJob::class, [
                'input' => $request->input()
            ]);

            $permission = $this->run( CreateModelInstanceJob::class, [
                'namespace' => '\Framework\Permission' 
            ]);
            
            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => $permission
            ]);

            $permission = $this->run( FindRegisterJob::class, [
                'repo' => $repo,
                'field' => [
                    'name' => 'id',
                    'value' => $this->id
                ]
            ]);            
                
            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => $permission
            ]);

            $permission = $this->run( FillWithRepoJob::class, [
                'repo' => $repo,
                'data' => $validatedInput
            ]);
            
            $permission = $this->run( SaveModelJob::class, [
                'model' => $permission
            ]);

            $permission = $this->run( FormatPermissionToJsonJob::class, [
                'permission' => $permission
            ]);

            return $this->run( new RespondWithJsonJob( $permission ) ); 
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }
    }
}
