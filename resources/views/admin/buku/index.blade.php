@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Buku</h2>
    <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">Tambah Buku</a>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($buku as $b)
        <tr>
            <td>{{ $b->kode_buku }}</td>
            <td>{{ $b->judul_buku }}</td>
            <td>{{ $b->pengarang }}</td>
            <td>{{ $b->penerbit }}</td>
            <td>{{ $b->tahun_terbit }}</td>
            <td>{{ $b->stok }}</td>
            <td>
                <a href="{{ route('admin.buku.edit', $b->id_buku) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.buku.destroy', $b->id_buku) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
