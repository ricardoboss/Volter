<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passwords', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('version')->default(0);
            $table->string('name');
            $table->mediumText('notes');
            $table->mediumText('value');

            $table->timestamp('created_at')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passwords');
    }
}
