@extends('layouts.app')
@section('content')
<h2>Pengembalian Buku</h2>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{ $t->buku->judul_buku }}</td>
            <td>{{ $t->tanggal_pinjam }}</td>
            <td>
                <form action="{{ route('siswa.pengembalian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_transaksi" value="{{ $t->id_transaksi }}">
                    <button class="btn btn-success btn-sm">Kembalikan</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
