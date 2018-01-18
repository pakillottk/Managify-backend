<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');

            $table->string( 'role_name' );
            $table->integer( 'company_id' )->unsigned()->nullable();
            
            $table  ->foreign( 'company_id' )
                    ->references( 'id' )
                    ->on( 'companies' )
                    ->onDelete( 'cascade' );

            $table->unique( [ "role_name", "company_id" ] );

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
        Schema::dropIfExists('roles');
    }
}
