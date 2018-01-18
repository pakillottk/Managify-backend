<?php
namespace App\Services\Api\Features;

//Database related
use App\Domains\Database\Jobs\GetModelRepositoryJob;
use App\Domains\Database\Jobs\RemoveFromRepoJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class DeleteRoleFeature extends Feature
{
    private $id;

    public function __construct( $id ) {
        $this->id = (int) $id;
    }  

    public function handle(Request $request)
    {
        try {
            $repo = $this->run( GetModelRepositoryJob::class, [
                'model' => new \Framework\Role()
            ]);
                        
            $success = $this->run( RemoveFromRepoJob::class, [
                'repo' => $repo,
                'id' => $this->id
            ]);

            if( $success ) {
                return $this->run( 
                    new RespondWithJsonJob([
                        'id_deleted' => $this->id
                    ])
                );
            }

            return $this->run( new RespondWithJsonErrorJob( 'Deletion failed. Check resource id' ) );
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() ) );
        }
    }
}
