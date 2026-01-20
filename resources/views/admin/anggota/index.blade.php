@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Anggota</h2>
    <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary">Tambah Anggota</a>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($anggota as $a)
        <tr>
            <td>{{ $a->nis }}</td>
            <td>{{ $a->nama_anggota }}</td>
            <td>{{ $a->kelas }}</td>
            <td>{{ $a->jurusan }}</td>
            <td>{{ $a->username }}</td>
            <td>
                <a href="{{ route('admin.anggota.edit', $a->id_anggota) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.anggota.destroy', $a->id_anggota) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
