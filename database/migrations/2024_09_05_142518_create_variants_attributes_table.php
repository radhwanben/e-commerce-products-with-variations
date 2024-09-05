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
        Schema::create('variants_attributes', function (Blueprint $table) {
            $table->foreignId('variant_id')->constrained('variants')->onDelete('cascade');
            $table->foreignId('attribute_value_id')->constrained('attributes_values')->onDelete('cascade');
            $table->primary(['variant_id', 'attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants_attributes');
    }
};
