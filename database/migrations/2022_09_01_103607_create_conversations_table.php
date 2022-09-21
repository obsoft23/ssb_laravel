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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_user_id');
            $table->foreign('from_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('business_account_id');
            $table->foreign('business_account_id')->references('business_account_id')->on('business_accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('most_recent_message')->nullable();
            $table->string('blocked')->nullable();
            $table->string('holding_conversation_id');
            $table->string("read")->nullable();
            $table->string("last_seen")->nullable();
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
        Schema::dropIfExists('conversations');
    }
};
