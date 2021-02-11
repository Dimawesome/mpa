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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pages');
        Schema::enableForeignKeyConstraints();
        
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->string('language')->nullable();
            $table->string('title')->nullable();
            $table->text('visible_to')->nullable();
            $table->string('status')->nullable()->default('inactive');
            $table->boolean('is_default')->default(0);
            $table->string('page_name')->default('page');
            $table->string('is_deleted')->default(0);

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
