@extends('layouts.app')
@section('content')
<h1>Dashboard Admin</h1>
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Kelola Buku</h5>
                <p class="card-text">Manajemen data buku perpustakaan.</p>
                <a href="{{ route('admin.buku') }}" class="btn btn-light">Kelola</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Kelola Transaksi</h5>
                <p class="card-text">Peminjaman dan pengembalian buku.</p>
                <a href="{{ route('admin.transaksi') }}" class="btn btn-light">Kelola</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Kelola Anggota</h5>
                <p class="card-text">Manajemen data anggota (siswa).</p>
                <a href="{{ route('admin.anggota') }}" class="btn btn-light">Kelola</a>
            </div>
        </div>
    </div>
</div>
@endsection
