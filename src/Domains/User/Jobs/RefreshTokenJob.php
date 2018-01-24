<?php
namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;

use App\Data\Services\LoginProxy;

class RefreshTokenJob extends Job
{
    private $proxy;
    private $input;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $input )
    {
        $this->proxy = new LoginProxy();
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->proxy->attemptRefresh( $this->input[ 'refresh_token' ] );
    }
}
