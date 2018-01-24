<?php
namespace App\Services\Api\Features;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

use App\Domains\User\Jobs\LogoutWithProxyJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class LogoutFromApiFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            $response = $this->run( LogoutWithProxyJob::class );

            return $this->run( new RespondWithJsonJob( $response ) );
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() )  );
        }  
    }
}
