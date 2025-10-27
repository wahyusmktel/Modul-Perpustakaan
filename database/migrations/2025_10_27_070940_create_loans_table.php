<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $t) {
            $t->id();
            $t->foreignId('member_id')->constrained()->cascadeOnDelete();
            $t->date('loan_date');
            $t->date('due_date');
            $t->date('return_date')->nullable();
            $t->unsignedInteger('total_fine')->default(0); // rupiah
            $t->enum('status', ['open', 'closed', 'overdue'])->default('open');
            $t->timestamps();

            $t->index(['member_id', 'status']);
            $t->index(['due_date']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
