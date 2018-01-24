<?php
namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use App\Data\Services\LoginProxy;

class LogoutWithProxyJob extends Job
{
    private $proxy;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->proxy = new LoginProxy();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->proxy->logout();
    }
}
