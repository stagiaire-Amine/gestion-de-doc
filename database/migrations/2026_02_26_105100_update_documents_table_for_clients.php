<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'client_id')) {
                $table->foreignId('client_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('documents', 'expires_at')) {
                $table->date('expires_at')->nullable()->after('status');
            }
            // User requested 'type' as required. Existing 'category' might be used for this.
            // I'll add 'type' if it doesn't exist, or just use category.
            // But let's follow the user's schema exactly by adding 'type'.
            if (!Schema::hasColumn('documents', 'type')) {
                $table->string('type')->nullable()->after('client_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('client_id');
            $table->dropColumn(['expires_at', 'type']);
        });
    }
};
