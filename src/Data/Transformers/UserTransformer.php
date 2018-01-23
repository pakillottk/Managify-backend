<?php

namespace App\Data\Transformers;

use App\Data\Transformers\BaseTransformer;
use App\Data\Transformers\CompanyTransformer;
use App\Data\Transformers\RoleTransformer;

class UserTransformer extends BaseTransformer {
    protected function getRelationTransformer( $relation ) {
        switch( $relation ) {
            case "company": {
                return new CompanyTransformer();
            }
            case "role": {
                return new RoleTransformer();
            }
        }

        return null;
    }

    public function _transform( $user ) {
        return [
            'id'         => (int) $user->id,
            'username'   => (string) $user->username,
            'name'       => (string) $user->name,
            'email'      => (string) $user->email,
            'avatar_url' => $user->avatar_url,
            'company_id' => is_null($user->company_id) ? null : (int)$user->company_id,
            'role_id'    => is_null($user->role_id) ? null : (int)$user->role_id,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }
}