<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_poes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('suggested_pap_id')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->string('pap_txt')->nullable();
            $table->string('geolocation');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('mfo_id');
            $table->unsignedBigInteger('key_id');
            $table->unsignedBigInteger('service_region_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('locker_user_id')->nullable();
            $table->unsignedBigInteger('thematic_area_cluster_id');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->decimal('total',19,2);
            $table->dateTime('datetime_locked')->nullable();
            $table->enum('locked',[0,1])->default(0);

            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('suggested_pap_id')->references('id')->on('list_of_paps')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('thematic_area_cluster_id')->references('id')->on('thematic_areas_clusters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('locker_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('fund_chargeability_classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('service_region_id')->references('id')->on('service_regions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('form_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mfo_id')->references('id')->on('mfos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('key_id')->references('id')->on('kdp_kp_ks')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_poes');
        Schema::table('form_poes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
