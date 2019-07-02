<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id');
            $table->uuid('user_id');
            $table->string('content');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('entries', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('entries');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
