<?php

namespace App\Data\Transformers;

use App\Data\Transformers\BaseTransformer;

class RoleTransformer extends BaseTransformer {
    public function transform( $data, $toHide = [] ) {
        $role = $data; 
        $output = [
            'id' => (int) $role->id,
            'role_name' => (string) $role->role_name,
            'created_at' => $role->created_at,
            'updated_at' => $role->updated_at
        ];
        
        return $this->hideFields( $output, $toHide );
    }
}