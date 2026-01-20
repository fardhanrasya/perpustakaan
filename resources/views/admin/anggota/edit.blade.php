@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Edit Anggota</div>
    <div class="card-body">
        <form action="{{ route('admin.anggota.update', $anggota->id_anggota) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3"><label>NIS</label><input type="text" name="nis" class="form-control" value="{{ $anggota->nis }}" required></div>
            <div class="mb-3"><label>Nama Anggota</label><input type="text" name="nama_anggota" class="form-control" value="{{ $anggota->nama_anggota }}" required></div>
            <div class="mb-3"><label>Kelas</label><input type="text" name="kelas" class="form-control" value="{{ $anggota->kelas }}" required></div>
            <div class="mb-3"><label>Jurusan</label><input type="text" name="jurusan" class="form-control" value="{{ $anggota->jurusan }}" required></div>
            <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" value="{{ $anggota->username }}" required></div>
            <div class="mb-3"><label>Password (Kosongkan jika tidak diubah)</label><input type="password" name="password" class="form-control"></div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
