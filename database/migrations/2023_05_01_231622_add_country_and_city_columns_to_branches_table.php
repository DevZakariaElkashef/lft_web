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
        Schema::table('branches', function (Blueprint $table) {
            $table->bigInteger('country_id')->unsigned()->nullable()->after('country');
            $table->foreign('country_id')->references('id')->on('cities_and_regions')->onDelete('set null');
            $table->bigInteger('city_id')->unsigned()->nullable()->after('city');
            $table->foreign('city_id')->references('id')->on('cities_and_regions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
