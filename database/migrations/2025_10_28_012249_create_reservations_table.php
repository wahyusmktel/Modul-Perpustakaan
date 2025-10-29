<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('member_id')->constrained()->cascadeOnDelete();
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();   // reservasi per judul
            $t->enum('status', ['queued', 'ready', 'picked', 'cancelled'])->default('queued');
            $t->timestamp('queued_at')->nullable();
            $t->timestamp('ready_at')->nullable();
            $t->timestamp('ready_expire_at')->nullable();
            $t->timestamp('picked_at')->nullable();
            $t->timestamps();

            $t->index(['book_id', 'status']);
            $t->unique(['member_id', 'book_id', 'status']); // 1 reservasi aktif/queued per member per judul
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
