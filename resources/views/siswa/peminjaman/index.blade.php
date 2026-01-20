@extends('layouts.app')
@section('content')
<h2>Peminjaman Buku</h2>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($buku as $b)
        <tr>
            <td>{{ $b->judul_buku }}</td>
            <td>{{ $b->pengarang }}</td>
            <td>{{ $b->penerbit }}</td>
            <td>{{ $b->stok }}</td>
            <td>
                @if($b->stok > 0)
                <form action="{{ route('siswa.peminjaman.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_buku" value="{{ $b->id_buku }}">
                    <button class="btn btn-primary btn-sm">Pinjam</button>
                </form>
                @else
                <span class="badge bg-secondary">Stok Habis</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
