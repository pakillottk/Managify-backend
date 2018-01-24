<?php
namespace App\Services\Api\Features;

use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

use App\Domains\User\Jobs\RefreshTokenJob;

//Responses
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;

use Exception;

class RefreshTokenFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            $response = $this->run( RefreshTokenJob::class, [
                'input' => $request->input()
            ]);

            return $this->run( new RespondWithJsonJob( $response ) );
        } catch( Exception $e ) {
            return $this->run( new RespondWithJsonErrorJob( $e->getMessage() )  );
        } 
    }
}
