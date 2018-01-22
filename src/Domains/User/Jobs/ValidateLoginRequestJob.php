<?php
namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use Exception;

class ValidateLoginRequestJob extends Job
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
        if( !isset( $this->input[ 'username' ] ) ) {
            throw new Exception( 'username is required' );
        }
        if( !isset( $this->input[ 'password' ] ) ) {
            throw new Exception( 'password is required' );
        }

        return [
            'username' => trim( $this->input[ 'username' ] ),
            'password' => $this->input[ 'password' ]
        ];
    }
}
