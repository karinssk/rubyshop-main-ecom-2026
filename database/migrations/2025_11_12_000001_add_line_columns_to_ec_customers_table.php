<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ec_customers', function (Blueprint $table) {
            if (! Schema::hasColumn('ec_customers', 'line_id')) {
                $table->string('line_id')->nullable()->unique()->after('phone');
            }

            if (! Schema::hasColumn('ec_customers', 'line_avatar')) {
                $table->string('line_avatar')->nullable()->after('line_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ec_customers', function (Blueprint $table) {
            if (Schema::hasColumn('ec_customers', 'line_avatar')) {
                $table->dropColumn('line_avatar');
            }

            if (Schema::hasColumn('ec_customers', 'line_id')) {
                $table->dropColumn('line_id');
            }
        });
    }
};
