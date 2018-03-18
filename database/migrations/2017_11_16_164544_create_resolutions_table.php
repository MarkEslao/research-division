<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolutions', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('number');
            $table->unsignedInteger('series');
            $table->longText('title');
            $table->longText('keywords');
            $table->boolean('is_accepting')->default(false);
            $table->boolean('is_monitoring')->default(false);
            $table->boolean('is_monitored')->default(false);
            $table->text('pdf_file_path')->nullable();
            $table->text('pdf_file_name')->nullable();
            $table->text('pdf_link')->nullable();
            $table->text('facebook_post_id')->nullable();
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
        Schema::dropIfExists('resolutions');
    }
}
