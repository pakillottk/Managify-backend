<?php
namespace App\Domains\User\Tests\Jobs;

use App\Domains\User\Jobs\ValidateInputForRoleJob;
use Tests\TestCase;

class ValidateInputForRoleJobTest extends TestCase
{
    public function test_validate_input_for_role_job()
    {
        /*
        $job = new ValidateInputForRoleJob( [] );        
        $this->expectExceptionMessage( 'Role name is required' );
        $job->handle();
        */
        /*
        $job = new ValidateInputForRoleJob( [ 'role_name' => null ] );        
        $this->expectExceptionMessage( 'Role name is required' );
        $job->handle();
        */
        /*
        $job = new ValidateInputForRoleJob( [ 'role_name' => '' ] );        
        $this->expectExceptionMessage( 'contains invalid characters' );
        $job->handle();
        */
        /*
        $job = new ValidateInputForRoleJob( [ 'role_name' => '@#½½~¬' ] );        
        $this->expectExceptionMessage( 'contains invalid characters' );
        $job->handle();
        */
        $validInput = [ 'role_name' => 'admin' ];
        $job = new ValidateInputForRoleJob( $validInput );        
        $this->assertEquals( $job->handle(), $validInput );
    }
}
