<?php

namespace App\Data\Services;

use App\Data\Repositories\Repository;

class GetScopeFromPermissions {
    private $repo;
    
    public function __construct() {
        $this->repo = new Repository( new \Framework\Permission() );
    }

    protected function permissionToScopes( $permission ) {
        $scope = '';
        $name = $permission->permission;
        if( $permission->read ) {
            $scope = $scope.$name.'-read-allowed ';
        }
        if( $permission->write ) {
            $scope = $scope.$name.'-write-allowed ';
        }
        if( $permission->delete ) {
            $scope = $scope.$name.'-delete-allowed ';
        }

        return $scope;
    }

    protected function getPermissions( $role_id ) {
        return $this->repo->getByAttributes( [ 'role_id' => $role_id ] );
    }

    public function getScope( $user ) {
        if( is_null( $user ) ) {
            return '';
        }

        $scope = '';
        $permissions = $this->getPermissions( $user->role_id );
        foreach( $permissions as $permission ) {
            $scope = $scope.($this->permissionToScopes( $permission ) );
        }

        return trim( $scope );
    }
}