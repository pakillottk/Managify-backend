<?php
namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use App\Data\Services\LoginProxy;

class RunLoginProxyJob extends Job
{
    private $proxy;
    private $username;
    private $password;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $username, $password )
    {
        $this->proxy = new LoginProxy();
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->proxy->attemptLogin( $this->username, $this->password );
    }
}
