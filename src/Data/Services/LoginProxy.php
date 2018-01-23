<?php

namespace App\Data\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Data\Repositories\Repository;
use Exception;

class LoginProxy {
    const REFRESH_TOKEN = 'refreshToken';

    private $http;
    private $userRepo;

    public function __construct() {
        $this->http = new Client();
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
        $oauthConfig = [
            'grant_type'    => $grantType,
            'client_id'     => (int)env( 'PASSWORD_CLIENT_ID' ),
            'client_secret' => env( 'PASSWORD_CLIENT_SECRET' ),
            'scope'         => '*'
        ];
        $data = array_merge( $oauthConfig, $data );
        
        request()->merge( $data );
        $request = Request::create(
            '/oauth/token',
            'POST'
        );
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