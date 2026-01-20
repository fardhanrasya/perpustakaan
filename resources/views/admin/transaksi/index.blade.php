@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Transaksi</h2>
    <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{ $t->id_transaksi }}</td>
            <td>{{ $t->anggota->nama_anggota }} ({{ $t->anggota->nis }})</td>
            <td>{{ $t->buku->judul_buku }}</td>
            <td>{{ $t->tanggal_pinjam }}</td>
            <td>{{ $t->tanggal_kembali ?? '-' }}</td>
            <td>
                @if($t->status == 'pinjam')
                    <span class="badge bg-warning">Pinjam</span>
                @else
                    <span class="badge bg-success">Kembali</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.transaksi.edit', $t->id_transaksi) }}" class="btn btn-info btn-sm">Edit</a>
                <form action="{{ route('admin.transaksi.destroy', $t->id_transaksi) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
