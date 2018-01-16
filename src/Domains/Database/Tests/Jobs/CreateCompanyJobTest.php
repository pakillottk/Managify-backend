<?php
namespace App\Domains\Database\Tests\Jobs;

use App\Domains\Database\Jobs\CreateCompanyJob;
use Tests\TestCase;

class CreateCompanyJobTest extends TestCase
{
    public function test_create_company_job()
    {
        $validInput = [
            'nif' => '123456789',
            'name' => 'a',
            'email' => 'mail@to.com',
            'phone' => '123456789',
            'address' => null,
            'logo_url' => null
        ];
        $job = $this->app->make( 'App\Domains\Database\Jobs\CreateCompanyJob' );
        $this->assertEquals( json_encode( $job->handle( $validInput ) ), json_encode( $validInput ) );
    }
}
