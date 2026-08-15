<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('pos_product_mappings', function (Blueprint $table): void {
            $table->id();
            $table->string('source')->default('default');
            $table->string('pos_product_id')->nullable();
            $table->string('pos_name');
            $table->string('normalized_name');
            $table->unsignedBigInteger('product_id');
            $table->string('matched_by')->default('name');
            $table->unsignedInteger('last_quantity')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->unique(['source', 'normalized_name']);
            $table->unique(['source', 'pos_product_id']);
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_product_mappings');
    }
};
