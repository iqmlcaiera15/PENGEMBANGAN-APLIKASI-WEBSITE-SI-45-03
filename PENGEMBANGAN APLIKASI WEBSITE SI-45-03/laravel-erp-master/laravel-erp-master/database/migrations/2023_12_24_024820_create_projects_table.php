<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->double('estimasi_harga');
            $table->double('harga');
            $table->text('deskripsi');
            $table->integer('status');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
        Schema::create('project_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('project')->cascadeOnDelete();
            $table->foreignId('produk_supplier_id')->constrained('produk_supplier')->cascadeOnDelete();
            $table->double('harga');
            $table->integer('jumlah');
            $table->double('total_harga');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_detail');
        Schema::dropIfExists('project');
    }
};
