<?php
namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use Exception;

class ValidateInputForPermissionJob extends Job
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
        $input = $this->input;

        if( !isset( $input[ 'permission' ] ) ) {
            throw new Exception( 'permission is required' );
        }

        if( !isset( $input[ 'role_id' ] ) ) {
            throw new Exception( 'read is required' );
        }

        return array_merge( $input, [ 'role_id' => (int)$input[ 'role_id' ] ] );
    }
}
