<?php

namespace App\Data\Transformers;

use App\Data\Transformers\BaseTransformer;
use App\Data\Transformers\RoleTransformer;

class PermissionTransformer extends BaseTransformer {
    protected function getRelationTransformer( $relation ) {
        switch( $relation ) {
            case "role": {
                return new RoleTransformer();
            }
        }

        return null;
    }

    public function _transform( $permission ) {
        return [
            'id'         => (int) $permission->id,
            'permission' => (string) $permission->permission,
            'read'       => (boolean) $permission->read,
            'write'      => (boolean) $permission->write,
            'delete'     => (boolean) $permission->delete,
            'created_at' => $permission->created_at,
            'updated_at' => $permission->updated_at
        ];
    }
}