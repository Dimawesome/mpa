<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('module_card');
        Schema::enableForeignKeyConstraints();

        Schema::create('module_card', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->string('name');
            $table->bigInteger('page_id')->unsigned();
            $table->string('module_name')->nullable();

            $table->string('title')->nullable();
            $table->text('url')->nullable();
            $table->string('url_type')->nullable();
            $table->text('text');
            $table->string('width');
            $table->string('align');

            $table->integer('order');
            $table->boolean('is_active')->default(0);

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
        Schema::dropIfExists('module_card');
    }
}
