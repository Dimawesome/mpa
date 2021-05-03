<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateModuleFileHasFiles
 */
class CreateModuleFileHasFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('module_file_has_files');
        Schema::enableForeignKeyConstraints();

        Schema::create('module_file_has_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('module_file_id')->unsigned();
            $table->text('url');
            $table->text('width');
            $table->text('open');
            $table->integer('order');

            $table->foreign('module_file_id')->references('id')->on('module_file')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('module_file_has_files');
    }
}
