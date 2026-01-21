<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('group_name')->nullable()->after('name');
        });

        // OPTIONAL: if you want uniqueness by (group_name, name, guard_name)
        Schema::table('permissions', function (Blueprint $table) {
            // Drop existing unique index on (name, guard_name)
            $table->dropUnique('permissions_name_guard_name_unique');

            // Create new unique index including group_name
            $table->unique(['group_name', 'name', 'guard_name'], 'permissions_group_name_name_guard_name_unique');
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            // Revert unique index changes first if you made them
            if (Schema::hasColumn('permissions', 'group_name')) {
                $table->dropUnique('permissions_group_name_name_guard_name_unique');
                $table->unique(['name', 'guard_name'], 'permissions_name_guard_name_unique');
                $table->dropColumn('group_name');
            }
        });
    }
};
