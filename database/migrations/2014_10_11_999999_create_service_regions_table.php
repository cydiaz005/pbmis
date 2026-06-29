<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_regions', function (Blueprint $table) {
            $table->id();
            $table->string('service_region');
            $table->string('accronym', 10)->nullable();
            $table->string('co', 10)->nullable();
            $table->string('fillable', 10)->default(1);
            $table->unsignedBigInteger('office_id')->nullable();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('service_regions');
    }
}
