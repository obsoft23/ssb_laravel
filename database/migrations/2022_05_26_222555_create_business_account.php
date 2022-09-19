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
        Schema::create('business_accounts', function (Blueprint $table) {
            $table->bigIncrements('business_account_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('business_name')->unique();
            $table->string('email')->unique();	
            $table->string('phone');
            $table->text('business_descripition');
            $table->string('opening_time');
            $table->string('closing_time');
            $table->string('vocation_id')->index()->nullable();
            $table->string('business_sub_category')->index();
            $table->string('full_address');
            $table->string('house_no')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city_or_town')->index();
            $table->string('county_locality');
            $table->string('country_nation');
            $table->string('latitude')->index();
            $table->string('longtitude')->index();
            $table->double('rating', 5, 2)->nullable()->index();
            $table->json('active_days')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('business_account');
    }
};
