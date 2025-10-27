<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loan_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $t->foreignId('book_item_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('fine_amount')->default(0); // denda per item (rupiah)
            $t->timestamp('returned_at')->nullable();
            $t->timestamps();

            $t->unique(['loan_id', 'book_item_id']);        // 1 item unik per loan
            $t->index(['book_item_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('loan_items');
    }
};
