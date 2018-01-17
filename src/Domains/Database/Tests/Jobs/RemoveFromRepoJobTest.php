<?php
namespace App\Domains\Database\Tests\Jobs;

use App\Domains\Database\Jobs\RemoveFromRepoJob;
use Tests\TestCase;

use App\Data\Repositories\Repository;

class RemoveFromRepoJobTest extends TestCase
{
    public function test_remove_from_repo_job()
    {
        $repo = new Repository( new \Framework\Company() );
        $id = 1;

        $job = new RemoveFromRepoJob( $repo, $id );
        $this->assertEquals( $job->handle(), true );
    }
}
