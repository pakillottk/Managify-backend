<?php
namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use Exception;

class ValidateInputForCompanyJob extends Job
{
    private $input = [];
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
        //NIF (exception if field not in input)
        $nif = trim( $input[ 'nif' ] );
        if( strlen( $nif ) !== 9 ) {
            throw new Exception( 'NIF length must be 9 chars' );
        }
        //NAME (exception if field not in input)
        $name = trim( $input[ 'name' ] );
        if( empty( $name ) ) {
            throw new Exception( 'NAME is required' );
        }
        //EMAIL (exception if field not in input)
        $email = trim( $input[ 'email' ] );
        if( empty( $email ) ) {
            throw new Exception( 'EMAIL is required' );
        }
        if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            throw new Exception( 'EMAIL is not valid' );
        }
        //PHONE
        $phone = isset( $input[ 'phone' ] ) ? trim( $input[ 'phone' ] ) : null;
        if( !empty( $phone ) ) {
            if( !preg_match("/[0-9]{9}/", $phone ) ) {
                throw new Exception( 'PHONE is not valid' );
            }
        }
        return [
            'nif' => $nif,
            'name' => $name,
            'email' => $email,
            'address' => isset( $input[ 'address' ] ) ? trim( $input[ 'address' ] ) : null,
            'phone' => $phone,
            'logo_url' => isset( $input[ 'address' ] ) ? trim( $input[ 'logo_url' ] ) : null
        ];
    }
}
