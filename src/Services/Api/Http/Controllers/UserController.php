<?php
namespace App\Services\Api\Http\Controllers;

use Illuminate\Http\Request;
use Lucid\Foundation\Http\Controller;

use App\Services\Api\Features\GetUsersFeature;
use App\Services\Api\Features\CreateUserFeature;
use App\Services\Api\Features\UpdateUserFeature;
use App\Services\Api\Features\DeleteUserFeature;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->serve( GetUsersFeature::class );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->serve( CreateUserFeature::class );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->serve( UpdateUserFeature::class, [ 'id' => $id ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->serve( DeleteUserFeature::class, [ 'id' => $id ] );
    }
}
