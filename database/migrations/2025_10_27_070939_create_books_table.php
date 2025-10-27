<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('sarpras_asset_id');   // referensi aset "Buku" di Sarpras
            $t->string('code')->unique()->nullable();     // kode internal perpustakaan (opsional)
            $t->string('title');
            $t->string('authors')->nullable();
            $t->string('publisher')->nullable();
            $t->string('isbn', 20)->nullable();
            $t->unsignedSmallInteger('year')->nullable();
            $t->string('rack_location')->nullable();
            $t->string('subject')->nullable();
            $t->string('language', 8)->nullable();
            $t->text('notes')->nullable();
            $t->enum('status', ['available', 'restricted', 'archived'])->default('available');
            $t->timestamps();

            $t->index(['sarpras_asset_id']);
            $t->index(['title']);
            $t->index(['isbn']);
            $t->index(['status']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
