<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creates the superuser role
        $roleId = DB::table( 'roles' )->insertGetId([
            'role_name'  => 'superuser',
            'company_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        //Creates the default user
        DB::table( 'users' )->insert([
            'username' => 'root',
            'password' => Hash::make( 'root' ),
            'name' => 'root',
            'role_id' => $roleId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
