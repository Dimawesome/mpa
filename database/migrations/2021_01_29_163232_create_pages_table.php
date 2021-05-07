<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePagesTable
 */
class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
//        Schema::disableForeignKeyConstraints();
//        Schema::dropIfExists('pages');
//        Schema::enableForeignKeyConstraints();
        
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->string('title')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_deleted')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
}
