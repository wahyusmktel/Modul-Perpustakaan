<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('copy_no');                 // eksemplar ke-
            $t->string('barcode')->unique();                // barcode unik per eksemplar
            $t->enum('condition', ['new', 'good', 'fair', 'poor', 'lost'])->default('good');
            $t->enum('status', ['available', 'on_loan', 'reserved', 'lost', 'repair'])->default('available');
            $t->timestamps();

            $t->unique(['book_id', 'copy_no']);             // copy_no unik per judul
            $t->index(['status']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('book_items');
    }
};
