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
            $table->string('name');
            $table->text('url')->nullable();
            $table->integer('order')->unsigned();
            $table->string('is_active')->default(0);

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
