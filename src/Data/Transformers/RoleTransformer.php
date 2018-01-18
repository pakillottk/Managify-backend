<?php

namespace App\Data\Transformers;

use App\Data\Transformers\BaseTransformer;
use App\Data\Queries\Query;

class RoleTransformer extends BaseTransformer {
    public function transform( $data, ?Query $query ) {
        $role = $data; 
        $output = [
            'id' => (int) $role->id,
            'role_name' => (string) $role->role_name,
            'company_id' =>  $role->company_id !== null ? (int)$role->company_id : null, 
            'created_at' => $role->created_at,
            'updated_at' => $role->updated_at
        ];
        
        return $this->hideFields( $output, $query );
    }
}