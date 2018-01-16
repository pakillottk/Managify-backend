<?php
namespace App\Domains\User\Tests\Jobs;

use App\Domains\User\Jobs\ValidateInputForCompanyJob;
use Tests\TestCase;

class ValidateInputForCompanyJobTest extends TestCase
{
    public function test_validate_input_for_company_job()
    {
        $fakeInput = [ 
            'nif' => '123456789',
            'name' => ' a ',
            'email' => 'asd@asd.com',
            'address' => 'fake street',
            'phone' => null,
            'logo_url' => ''
        ];
        
        $job = new ValidateInputForCompanyJob();
        $this->assertEquals(
            $job->handle( $fakeInput ),
            [
                'nif' => '123456789',
                'name' => 'a',
                'email' => 'asd@asd.com',
                'address' => 'fake street',
                'phone' => '',
                'logo_url' => ''
            ]        
        );
    }
}
