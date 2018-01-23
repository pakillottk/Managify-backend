<?php
namespace App\Services\Api\Http\Controllers;

use Illuminate\Http\Request;
use Lucid\Foundation\Http\Controller;

use App\Services\Api\Features\GetPermissionsFeature;
use App\Services\Api\Features\CreatePermissionFeature;
use App\Services\Api\Features\UpdatePermissionFeature;
use App\Services\Api\Features\DeletePermissionFeature;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->serve( GetPermissionsFeature::class );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->serve( CreatePermissionFeature::class );
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
        return $this->serve( UpdatePermissionFeature::class, [ 'id' => $id ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->serve( DeletePermissionFeature::class, [ 'id' => $id ] );
    }
}
