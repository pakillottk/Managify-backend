<?php
namespace App\Services\Api\Http\Controllers;

use Illuminate\Http\Request;
use Lucid\Foundation\Http\Controller;

use App\Services\Api\Features\LoginToApiFeature;
use App\Services\Api\Features\RefreshTokenFeature;
use App\Services\Api\Features\LogoutFromApiFeature;

class LoginController extends Controller
{
    public function login() {
        return $this->serve( LoginToApiFeature::class );
    }

    public function refresh() {
        return $this->serve( RefreshTokenFeature::class );
    }
 
    public function logout() {
        return $this->serve( LogoutFromApiFeature::class );
    }
}
