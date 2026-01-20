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
        // 1. Tabel Admin (Independen)
        Schema::create('admin', function (Blueprint $table) {
            $table->integer('id_admin')->autoIncrement();
            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('nama_admin', 100);
        });

        // 2. Tabel Anggota (Independen)
        Schema::create('anggota', function (Blueprint $table) {
            $table->integer('id_anggota')->autoIncrement();
            $table->string('nis', 20)->unique();
            $table->string('nama_anggota', 100);
            $table->string('kelas', 20);
            $table->string('jurusan', 50);
            $table->string('username', 50);
            $table->string('password', 255);
        });

        // 3. Tabel Buku (Independen)
        Schema::create('buku', function (Blueprint $table) {
            $table->integer('id_buku')->autoIncrement();
            $table->string('kode_buku', 20)->unique();
            $table->string('judul_buku', 255);
            $table->string('pengarang', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->integer('stok')->default(1);
        });

        // 4. Tabel Transaksi (Punya Foreign Key -> WAJIB TERAKHIR)
        Schema::create('transaksi', function (Blueprint $table) {
            $table->integer('id_transaksi')->autoIncrement();
            
            // Definisikan kolom foreign key dengan tipe yang SAMA PERSIS (integer)
            $table->integer('id_anggota');
            $table->integer('id_buku');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['pinjam', 'kembali'])->default('pinjam');

            // Definisikan Relasi
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade');
            $table->foreign('id_buku')->references('id_buku')->on('buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('buku');
        Schema::dropIfExists('anggota');
        Schema::dropIfExists('admin');
    }
};
