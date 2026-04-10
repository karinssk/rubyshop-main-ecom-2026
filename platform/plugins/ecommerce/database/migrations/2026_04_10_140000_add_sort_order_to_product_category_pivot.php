<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_product_category_product', function (Blueprint $table): void {
            if (! Schema::hasColumn('ec_product_category_product', 'sort_order')) {
                $table->integer('sort_order')->unsigned()->default(0)->after('product_id');
                $table->index(['category_id', 'sort_order'], 'ec_pcp_category_sort_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ec_product_category_product', function (Blueprint $table): void {
            if (Schema::hasColumn('ec_product_category_product', 'sort_order')) {
                $table->dropIndex('ec_pcp_category_sort_idx');
                $table->dropColumn('sort_order');
            }
        });
    }
};
