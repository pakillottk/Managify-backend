<?php
namespace App\Services\Api\Features;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

use App\Domains\User\Jobs\ValidateLoginRequestJob;
use App\Domains\User\Jobs\RunLoginProxyJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class LoginToApiFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            //1 - Validate the request
            $validatedInput = $this->run( ValidateLoginRequestJob::class, [
                'input' => $request->input()
            ]);
            //2 - Run the login proxy
            $response = $this->run( RunLoginProxyJob::class, [
                'username' => $validatedInput[ 'username' ],
                'password' => $validatedInput[ 'password' ]
            ]);
            //3 - Returns the token
            return $this->run( new RespondWithJsonJob( $response ) );
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() )  );
        }   
    }
}
