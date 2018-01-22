<?php

namespace App\Data\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Data\Repositories\Repository;
use Exception;

class LoginProxy {
    const REFRESH_TOKEN = 'refreshToken';

    private $userRepo;

    public function __construct() {
        $this->userRepo = new Repository( new \Framework\User() );
    }

    public function attemptLogin( $username, $password ) {
        try {
            $user = $this->userRepo->findBy( 'username', $username );
            return $this->proxy( 'password', [
                'username' => $username,
                'password' => $password
            ]);

        } catch( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }
    }

    public function proxy( $grantType, array $data = [] ) {
        $data = array_merge( $data, [
            'grant_type'    => $grantType,
            'client_id'     => env( 'PASSWORD_CLIENT_ID' ),
            'client_secret' => env( 'PASSWORD_CLIENT_SECRET' )
        ]);
        $request = Request::create(
            'oauth/token',
            'POST',
            $data
        );
        $request->headers->set( 'Content-Type', 'application/json' );

        $response = Route::dispatch( $request );
        if( !$response->isSuccessful() ) {
            throw new Exception( $response->content() );
        }

        $responseData = json_decode( $response->content() );
        return [
            'access_token' => $responseData->access_token,
            'expires_in' => $responseData->expires_in,
            'refresh_token' => $responseData->refresh_token
        ];
    }
}