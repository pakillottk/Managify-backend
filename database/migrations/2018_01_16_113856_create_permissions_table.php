<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');

            $table->string( 'permisssion' );
            $table->boolean( 'read' )->default( true );
            $table->boolean( 'write' )->default( false );
            $table->boolean( 'delete' )->default( false );
            $table->integer( 'user_id' )->unsigned();
            $table  ->foreign( 'user_id' )
                    ->references( 'id' )
                    ->on( 'users' )
                    ->onDelete( 'cascade' );

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
        Schema::dropIfExists('permissions');
    }
}
