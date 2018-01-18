<?php
namespace App\Services\Api\Http\Controllers;

use Illuminate\Http\Request;
use Lucid\Foundation\Http\Controller;

use App\Services\Api\Features\GetRolesFeature;
use App\Services\Api\Features\CreateRoleFeature;
use App\Services\Api\Features\UpdateRoleFeature;
use App\Services\Api\Features\DeleteRoleFeature;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->serve( GetRolesFeature::class ); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->serve( CreateRoleFeature::class );
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
        return $this->serve( UpdateRoleFeature::class, [ 'id' => $id ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->serve( DeleteRoleFeature::class, [ 'id' => $id ] );
    }
}
