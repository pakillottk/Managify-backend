<?php

namespace App\Data\Services;

use App\Data\Repositories\Repository;

class GetScopeFromPermissions {
    private $repo;
    private $rolesRepo;

    public function __construct() {
        $this->repo      = new Repository( new \Framework\Permission() );
        $this->rolesRepo = new Repository( new \Framework\Role() );
    }

    protected function permissionToScopes( $permission, $asArray = true ) {
        $scopes = [];
        $name = $permission->permission;
        if( $asArray ) {
            if( $permission->read ) {
                array_push( $scopes, $name.'-read-allowed' );
            }
            if( $permission->write ) {
                array_push( $scopes, $name.'-write-allowed' );
            }
            if( $permission->delete ) {
                array_push( $scopes, $name.'-delete-allowed' );
            }
        } else {
            if( $permission->read ) {
                $scopes[ $name.'-read-allowed' ] = 'Allows reading of'.$name;
            }
            if( $permission->write ) {
                $scopes[ $name.'-write-allowed' ] = 'Allows creation/update of'.$name;
            }
            if( $permission->delete ) {
                $scopes[ $name.'-delete-allowed' ] = 'Allows deletion of'.$name;
            }
        }

        return $scopes;
    }

    protected function getPermissions( $role_id ) 
    {
        if( is_null( $role_id ) ) {
            return $this->repo->all();
        }
        $role = $this->rolesRepo->find( $role_id );
        if( $role->role_name === "superuser" ) {
            return '*';
        }
        return $this->repo->getByAttributes( [ 'role_id' => $role_id ] );
    }

    protected function permissionsToScopes( $permissions, $asArray = true ) {
        $scopes = [];
        foreach( $permissions as $permission ) {
            $scopes = array_merge( $scopes, $this->permissionToScopes( $permission, $asArray ) );
        }

        return $scopes;
    }

    public function getScope( $user, $inString = true, $separator = ', ' ) {
        if( is_null( $user ) ) {
            return '';
        }

        $permissions = $this->getPermissions( $user->role_id );
        if( $permissions === '*' ) {
            return $permissions;   
        }
        $scopes = $this->permissionsToScopes( $permissions );    

        if(!$inString ) {
            return $scopes;
        }
        
        return implode( $separator, $scopes );
    }

    public function getAllScopes( $inString = true, $separator = ', ' ) {
        $permissions = $this->getPermissions( null );
        $scopes      = $this->permissionsToScopes( $permissions, false );

        if( !$inString ) {
            return $scopes;
        }

        return implode( $separator, $scopes );
    }
}