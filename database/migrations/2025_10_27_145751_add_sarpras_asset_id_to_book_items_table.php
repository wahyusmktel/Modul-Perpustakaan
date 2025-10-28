<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('book_items', function (Blueprint $t) {
            $t->unsignedBigInteger('sarpras_asset_id')->nullable()->after('book_id');
            $t->unique(['sarpras_asset_id']); // 1 eksemplar = 1 aset sarpras (unik)
        });
    }
    public function down(): void
    {
        Schema::table('book_items', function (Blueprint $t) {
            $t->dropUnique(['sarpras_asset_id']);
            $t->dropColumn('sarpras_asset_id');
        });
    }
};
