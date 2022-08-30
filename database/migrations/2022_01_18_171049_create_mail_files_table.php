<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_files', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('name');
            $table->unsignedBigInteger('mail_id');
            $table->timestamps();
            $table->foreign('mail_id')->references('id')->on('mails')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_files');
    }
}
