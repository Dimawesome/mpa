<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateModuleTextTable
 */
class CreateModuleTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('module_text');
        Schema::enableForeignKeyConstraints();

        Schema::create('module_text', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->string('name');
            $table->bigInteger('page_id')->unsigned();
            $table->string('module_name')->nullable();

            $table->text('text');

            $table->integer('order');
            $table->string('is_active')->default(0);

            $table->timestamps();

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
        Schema::dropIfExists('module_text');
    }
}
