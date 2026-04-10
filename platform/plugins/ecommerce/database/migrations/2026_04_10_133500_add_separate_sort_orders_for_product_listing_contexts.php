<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_products', function (Blueprint $table): void {
            if (! Schema::hasColumn('ec_products', 'sort_order_product_page')) {
                $table->integer('sort_order_product_page')->unsigned()->default(0)->after('order');
                $table->index('sort_order_product_page');
            }

            if (! Schema::hasColumn('ec_products', 'sort_order_category_page')) {
                $table->integer('sort_order_category_page')->unsigned()->default(0)->after('sort_order_product_page');
                $table->index('sort_order_category_page');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ec_products', function (Blueprint $table): void {
            if (Schema::hasColumn('ec_products', 'sort_order_category_page')) {
                $table->dropIndex(['sort_order_category_page']);
                $table->dropColumn('sort_order_category_page');
            }

            if (Schema::hasColumn('ec_products', 'sort_order_product_page')) {
                $table->dropIndex(['sort_order_product_page']);
                $table->dropColumn('sort_order_product_page');
            }
        });
    }
};
