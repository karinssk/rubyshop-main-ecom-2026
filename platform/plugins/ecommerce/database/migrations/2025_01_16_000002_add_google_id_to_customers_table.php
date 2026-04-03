<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ec_customers', function (Blueprint $table) {
            if (! Schema::hasColumn('ec_customers', 'google_id')) {
                $afterColumn = 'avatar';

                if (Schema::hasColumn('ec_customers', 'line_avatar')) {
                    $afterColumn = 'line_avatar';
                } elseif (Schema::hasColumn('ec_customers', 'line_id')) {
                    $afterColumn = 'line_id';
                }

                $table->string('google_id')->nullable()->unique()->after($afterColumn);
                $table->index('google_id');
            }

            if (! Schema::hasColumn('ec_customers', 'google_avatar')) {
                $table->string('google_avatar')->nullable()->after('google_id');
            }
        });
    }

    public function down(): void
    {
        $addedGoogleAvatar = Schema::hasColumn('ec_customers', 'google_avatar');

        Schema::table('ec_customers', function (Blueprint $table) use ($addedGoogleAvatar) {
            if ($addedGoogleAvatar) {
                $table->dropColumn('google_avatar');
            }
        });

        if ($addedGoogleAvatar) {
            Schema::table('ec_customers', function (Blueprint $table) {
                if (Schema::hasColumn('ec_customers', 'google_id')) {
                    $table->dropUnique('ec_customers_google_id_unique');
                    $table->dropIndex('ec_customers_google_id_index');
                    $table->dropColumn('google_id');
                }
            });
        }
    }
};
