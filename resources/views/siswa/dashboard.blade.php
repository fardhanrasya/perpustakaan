@extends('layouts.app')
@section('content')
<h1>Dashboard Siswa</h1>
<div class="row">
    <div class="col-md-6">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Peminjaman Buku</h5>
                <p class="card-text">Lihat buku yang tersedia dan pinjam.</p>
                <a href="{{ route('siswa.peminjaman') }}" class="btn btn-light">Pinjam Buku</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Pengembalian Buku</h5>
                <p class="card-text">Lihat buku yang sedang dipinjam dan kembalikan.</p>
                <a href="{{ route('siswa.pengembalian') }}" class="btn btn-light">Kembalikan Buku</a>
            </div>
        </div>
    </div>
</div>
@endsection
