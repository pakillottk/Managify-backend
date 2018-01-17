<?php
namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use Exception;

class ValidateInputForRoleJob extends Job
{
    private $input;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $input )
    {
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if( !isset( $this->input[ "role_name" ] ) ) {
            throw new Exception( 'Role name is required' );
        }

        if( !preg_match ( '/[a-Z 0-9]+/' , $this->input[ 'role_name' ] ) ) {
            throw new Exception( 'Role name contains invalid characters. (Only numbers and letters are allowed)' );
        }

        return [
            'role_name' => (string) $this->input['role_name']
        ];
    }
}
