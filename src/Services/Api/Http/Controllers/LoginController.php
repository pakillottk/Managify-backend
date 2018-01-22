<?php
namespace App\Services\Api\Http\Controllers;

use Illuminate\Http\Request;
use Lucid\Foundation\Http\Controller;

use App\Services\Api\Features\LoginToApiFeature;

class LoginController extends Controller
{
    public function login() {
        return $this->serve( LoginToApiFeature::class );
    }
}
