<?php
namespace App\Domains\Database\Tests\Jobs;

use App\Domains\Database\Jobs\CreateModelInstanceJob;
use Tests\TestCase;

class CreateModelInstanceJobTest extends TestCase
{
    public function test_create_model_instance_job()
    {
        $emptyCompany = new \Framework\Company();
        $validNamespace = '\Framework\Company';

        $validJob = new CreateModelInstanceJob( $validNamespace );
        $validModel = $validJob->handle();

        $this->assertEquals( $validModel, $emptyCompany );

        $badNamespace = '\Random\FakeClass';
        $badJob = new CreateModelInstanceJob( $badNamespace );
        $this->expectExceptionMessage( 'The given namespace is not a Model.' );
        $badJob->handle();
    }
}
