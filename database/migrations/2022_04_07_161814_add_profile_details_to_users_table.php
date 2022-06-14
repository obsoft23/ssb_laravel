<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*  Schema::table('users', function (Blueprint $table) {
          
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      /*  Schema::table('users', function (Blueprint $table) {
            $table->string('fullname');
            $table->string('phone');
            $table->text('bio');
            $table->string('image');
            $table->integer('has_professional_acc');
        });*/
    }
};
