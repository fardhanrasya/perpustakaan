@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Tambah Transaksi</div>
    <div class="card-body">
        <form action="{{ route('admin.transaksi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Anggota</label>
                <select name="id_anggota" class="form-select" required>
                    <option value="">Pilih Anggota</option>
                    @foreach($anggota as $a)
                        <option value="{{ $a->id_anggota }}">{{ $a->nama_anggota }} ({{ $a->nis }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Buku</label>
                <select name="id_buku" class="form-select" required>
                    <option value="">Pilih Buku</option>
                    @foreach($buku as $b)
                        <option value="{{ $b->id_buku }}">{{ $b->judul_buku }} (Stok: {{ $b->stok }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
