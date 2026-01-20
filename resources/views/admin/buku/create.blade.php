@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Tambah Buku</div>
    <div class="card-body">
        <form action="{{ route('admin.buku.store') }}" method="POST">
            @csrf
            <div class="mb-3"><label>Kode Buku</label><input type="text" name="kode_buku" class="form-control" required></div>
            <div class="mb-3"><label>Judul Buku</label><input type="text" name="judul_buku" class="form-control" required></div>
            <div class="mb-3"><label>Pengarang</label><input type="text" name="pengarang" class="form-control" required></div>
            <div class="mb-3"><label>Penerbit</label><input type="text" name="penerbit" class="form-control" required></div>
            <div class="mb-3"><label>Tahun Terbit</label><input type="number" name="tahun_terbit" class="form-control" required></div>
            <div class="mb-3"><label>Stok</label><input type="number" name="stok" class="form-control" required></div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
