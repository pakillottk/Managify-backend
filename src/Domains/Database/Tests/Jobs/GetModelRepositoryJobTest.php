<?php
namespace App\Domains\Database\Tests\Jobs;

use App\Domains\Database\Jobs\GetModelRepositoryJob;
use Tests\TestCase;

class GetModelRepositoryJobTest extends TestCase
{
    public function test_get_model_repository_job()
    {
        $job = new GetModelRepositoryJob( 'Framework\Company' );
        $repo = $job->handle();
        dd( $repo->all() );
    }
}
