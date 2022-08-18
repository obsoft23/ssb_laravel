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
        Schema::table('users', function (Blueprint $table) {
          // // $table->int('business_id');
          //  $table->foreign('business_id')->references('business_account_id')->on('business_accounts')->onUpdate('cascade')->onDelete('cascade');
          
          $table->unsignedBigInteger('business_id')->after('has_professional_acc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            // $table->int('business_id');
           //  $table->foreign('business_id')->references('business_account_id')->on('business_accounts')->onUpdate('cascade')->onDelete('cascade');
           $table->dropColumn(array('business_id'));
         });
    }
};
