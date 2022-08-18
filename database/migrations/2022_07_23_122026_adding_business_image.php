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
        
            $table->string('acc_main_image')->after('active_days')->nullable();
            $table->renameColumn('business_category', 'vocation_id')->nullable();
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
            $table->dropColumn(array('business_category'));
           
           
         });
    }
};
