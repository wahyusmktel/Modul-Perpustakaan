<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('members', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();              // NIS/NIP/ID anggota
            $t->string('name');
            $t->string('email')->nullable();
            $t->string('phone')->nullable();
            $t->string('address')->nullable();
            $t->date('expires_at')->nullable();
            $t->enum('status', ['active', 'inactive'])->default('active');
            $t->timestamps();

            $t->index(['name']);
            $t->index(['status']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
