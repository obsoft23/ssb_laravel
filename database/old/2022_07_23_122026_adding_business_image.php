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
        //
        Schema::table('business_accounts', function (Blueprint $table) {
        
           
            $table->renameColumn('vocation_id', 'vocation_id')->nullable();
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
        Schema::table('business_accounts', function (Blueprint $table) {
           
            $table->dropColumn(array('acc_main_image'));
            $table->dropColumn(array('vocation_id'));
           
           
         });
    }
};
