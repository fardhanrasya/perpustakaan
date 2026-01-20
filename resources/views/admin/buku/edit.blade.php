@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Edit Buku</div>
    <div class="card-body">
        <form action="{{ route('admin.buku.update', $buku->id_buku) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3"><label>Kode Buku</label><input type="text" name="kode_buku" class="form-control" value="{{ $buku->kode_buku }}" required></div>
            <div class="mb-3"><label>Judul Buku</label><input type="text" name="judul_buku" class="form-control" value="{{ $buku->judul_buku }}" required></div>
            <div class="mb-3"><label>Pengarang</label><input type="text" name="pengarang" class="form-control" value="{{ $buku->pengarang }}" required></div>
            <div class="mb-3"><label>Penerbit</label><input type="text" name="penerbit" class="form-control" value="{{ $buku->penerbit }}" required></div>
            <div class="mb-3"><label>Tahun Terbit</label><input type="number" name="tahun_terbit" class="form-control" value="{{ $buku->tahun_terbit }}" required></div>
            <div class="mb-3"><label>Stok</label><input type="number" name="stok" class="form-control" value="{{ $buku->stok }}" required></div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
