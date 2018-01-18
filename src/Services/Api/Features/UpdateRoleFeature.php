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
use App\Domains\User\Jobs\ValidateInputForRoleJob;
use App\Domains\Http\Jobs\FormatRoleToJsonJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class UpdateRoleFeature extends Feature
{
    private $id;

    public function __construct( $id ) {
        $this->id = $id;
    }

    public function handle(Request $request)
    {
        try {
            $validatedInput = $this->run( ValidateInputForRoleJob::class, [
                'input' => $request->input()
            ]);

            $role = $this->run( CreateModelInstanceJob::class, [
                'namespace' => '\Framework\Role' 
            ]);
            
            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => $role
            ]);

            $role = $this->run( FindRegisterJob::class, [
                'repo' => $repo,
                'field' => [
                    'name' => 'id',
                    'value' => $this->id
                ]
            ]);            
                
            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => $role
            ]);

            $role = $this->run( FillWithRepoJob::class, [
                'repo' => $repo,
                'data' => $validatedInput
            ]);
            
            $role = $this->run( SaveModelJob::class, [
                'model' => $role
            ]);

            $role = $this->run( FormatRoleToJsonJob::class, [
                'role' => $role
            ]);

            return $this->run( new RespondWithJsonJob( $role ) ); 
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }
    }
}
