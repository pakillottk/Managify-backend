<?php

namespace App\Data\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Data\Repositories\Repository;
use App\Data\Services\GetScopeFromPermissions;
use Illuminate\Support\Facades\DB;

use Exception;

class LoginProxy {
    private $userRepo;
    private $scopeGetter;

    public function __construct() {
        $this->userRepo = new Repository( new \Framework\User() );
        $this->scopeGetter = new GetScopeFromPermissions();
    }

    public function attemptLogin( $username, $password ) {
        try {
            $user = $this->userRepo->findBy( 'username', $username );
            return $this->proxy( 'password', [
                'username' => $username,
                'password' => $password
            ], $user );

        } catch( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }
    }

    public function attemptRefresh( $refreshToken ) {
        return $this->proxy( 'refresh_token', [ 'refresh_token' => $refreshToken ] );
    }

    public function proxy( $grantType, array $data = [], $user = null ) {        
        $oauthConfig = [
            'grant_type'    => $grantType,
            'client_id'     => (int)env( 'PASSWORD_CLIENT_ID' ),
            'client_secret' => env( 'PASSWORD_CLIENT_SECRET' )
        ];
        if( !is_null( $user ) ) {
            $scope = $this->scopeGetter->getScope( $user, true, ' ' );
            $oauthConfig[ 'scope' ] = $scope;
        }
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

    public function logout() {
        $accessToken = Auth::user()->token();
        $refreshToken = DB::table( 'oauth_refresh_tokens' )
                        ->where( 'access_token_id', $accessToken->id )
                        ->update([
                            'revoked' => true
                        ]);

        $accessToken->revoke();

        return 'Logout successfull';
    }
}