<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateModuleVideoCardTable
 */
class CreateModuleVideoCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('module_video_card', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->bigInteger('modules_id')->unsigned();
            $table->bigInteger('page_id')->unsigned();
            $table->string('module_name')->nullable();

            $table->string('name');
            $table->text('video_url');
            $table->string('video_autoplay')->default(0);
            $table->text('text');
            $table->string('width');

            $table->integer('order');
            $table->boolean('is_active')->default(0);

            $table->timestamps();

            $table->foreign('modules_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('module_video_card');
    }
}
