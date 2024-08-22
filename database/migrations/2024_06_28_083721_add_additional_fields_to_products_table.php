<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->after('price');
            $table->json('sizes')->nullable()->after('quantity');
            $table->json('colors')->nullable()->after('sizes');
            $table->string('sku')->unique()->nullable()->after('name');
            $table->text('short_description')->nullable()->after('description');
            $table->decimal('weight', 8, 2)->nullable()->after('description');
            $table->string('dimensions')->nullable()->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('sizes');
            $table->dropColumn('colors');
            $table->dropColumn('sku');
            $table->dropColumn('short_description');
            $table->dropColumn('weight');
            $table->dropColumn('dimensions');
        });
    }
};
