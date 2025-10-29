<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $t) {
            $t->unsignedSmallInteger('renew_count')->default(0)->after('status');
        });
    }
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $t) {
            $t->dropColumn('renew_count');
        });
    }
};
