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
            $table->string('original_name')->nullable()->after('title');
            $table->renameColumn('file_type', 'mime_type');
            $table->renameColumn('file_size', 'size_bytes');
            $table->boolean('is_starred')->default(false)->after('status');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('original_name');
            $table->renameColumn('mime_type', 'file_type');
            $table->renameColumn('size_bytes', 'file_size');
            $table->dropColumn('is_starred');
            $table->dropSoftDeletes();
        });
    }
};
