<?php
namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use Exception;
use Hash;

use App\Data\Validators\EmailValidator;

class ValidateInputForUserJob extends Job
{
    private $input = [];
    private $mailValidator;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $input )
    {
        $this->input = $input;
        $this->mailValidator = new EmailValidator();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $input = $this->input;        
        $username = trim( $input[ 'username' ] );
        if( empty( $username ) ) {
            throw new Exception( 'username is required' );
        }
        $password = $input[ 'password' ];
        $name = trim( $input[ 'name' ] );
        if( empty( $name ) ) {
            throw new Exception( 'name is required' );
        }
        if( isset( $input[ 'email' ] ) ) {
            if( !$this->mailValidator->validate( $input[ 'email' ] ) ) {
                throw new Exception( 'email is not valid' );
            }
        }

        return [
            'username'      => $username,
            'password'      => Hash::make( $password ),
            'name'          => $name,
            'email'         => !isset( $input[ 'email' ] ) ? null : $input[ 'email' ],
            'avatar_url'    => !isset( $input[ 'avatar_url' ] ) ? null : $input[ 'avatar_url' ],
            'company_id'    => !isset( $input[ 'company_id' ] ) ? null : (int)$input[ 'company_id' ],
            'role_id'       => !isset( $input[ 'role_id' ] ) ? null : (int)$input[ 'role_id' ]
        ];
    }
}
