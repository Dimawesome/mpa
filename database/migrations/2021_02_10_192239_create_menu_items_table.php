<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateMenuItemsTable
 */
class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('menu_items');
        Schema::enableForeignKeyConstraints();

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->string('name');
            $table->text('url')->nullable();
            $table->integer('order')->unsigned();
            $table->string('status')->default('inactive');
            $table->string('target')->nullable();
            $table->string('language')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
}
