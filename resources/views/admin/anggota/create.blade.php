@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Tambah Anggota</div>
    <div class="card-body">
        <form action="{{ route('admin.anggota.store') }}" method="POST">
            @csrf
            <div class="mb-3"><label>NIS</label><input type="text" name="nis" class="form-control" required></div>
            <div class="mb-3"><label>Nama Anggota</label><input type="text" name="nama_anggota" class="form-control" required></div>
            <div class="mb-3"><label>Kelas</label><input type="text" name="kelas" class="form-control" required></div>
            <div class="mb-3"><label>Jurusan</label><input type="text" name="jurusan" class="form-control" required></div>
            <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" required></div>
            <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
