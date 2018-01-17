<?php
namespace App\Domains\Database\Tests\Jobs;

use App\Domains\Database\Jobs\QueryWithRepoJob;
use Tests\TestCase;

use App\Data\Repositories\Repository;

class QueryWithRepoJobTest extends TestCase
{
    public function test_query_with_repo_job()
    {
        $repo = new Repository( new \Framework\Company() );
        $query = [ 
          'id' => 6 
        ];

        $job = new QueryWithRepoJob( $repo, $query );
        $this->assertEquals( count( $job->handle() ), 1 );

        $job = new QueryWithRepoJob( $repo, [ 'id' => 0 ] );
        $this->assertEquals( count( $job->handle() ), 0 );
    }
}
