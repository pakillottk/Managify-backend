<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {            
            $table->increments('id');

            $table->string('username')->unique();
            $table->string('password');
            $table->string( 'name' );
            $table->string( 'email' )->nullable();
            $table->string( 'avatar_url' )->nullable();
            $table->integer( 'company_id' )->unsigned()->nullable();
            $table->integer( 'role_id' )->unsigned()->nullable();

            $table  ->foreign( 'company_id' )
                    ->references( 'id' )
                    ->on( 'companies' )
                    ->onDelete( 'cascade' );

            $table  ->foreign( 'role_id' )
                    ->references( 'id' )
                    ->on( 'roles' );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
