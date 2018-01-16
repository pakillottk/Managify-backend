<?php
namespace App\Services\Api\Tests\Features;

use Tests\TestCase;
use App\Services\Api\Features\CreateCompanyFeature;

class CreateCompanyFeatureTest extends TestCase
{
    public function test_createcompanyfeature()
    {
        $data = [
            'nif' => '123456789',
            'name' => 'asdf',
            'email' => 'asd@a.com',
            'phone' => '123456789'
        ];
        $response = $this->json( 'POST', '/api/companies', $data )
            ->assertStatus( 200 )
            ->assertJsonStructure([
                'status',
                'data'
            ])
            ->assertJson([
                'data' => $data
            ]);      
    }
}
