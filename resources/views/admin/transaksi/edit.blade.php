@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Edit Transaksi</div>
    <div class="card-body">
        <form action="{{ route('admin.transaksi.update', $transaksi->id_transaksi) }}" method="POST">
            @csrf @method('PUT')
             <div class="mb-3">
                <label>Anggota</label>
                <input type="text" class="form-control" value="{{ $transaksi->anggota->nama_anggota }}" disabled>
            </div>
            <div class="mb-3">
                <label>Buku</label>
                <input type="text" class="form-control" value="{{ $transaksi->buku->judul_buku }}" disabled>
            </div>
            <div class="mb-3">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" value="{{ $transaksi->tanggal_pinjam }}" required>
            </div>
             <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" id="status" onchange="toggleKembali()">
                    <option value="pinjam" {{ $transaksi->status == 'pinjam' ? 'selected' : '' }}>Pinjam</option>
                    <option value="kembali" {{ $transaksi->status == 'kembali' ? 'selected' : '' }}>Kembali</option>
                </select>
            </div>
             <div class="mb-3" id="tgl_kembali_div" style="{{ $transaksi->status == 'pinjam' ? 'display:none' : '' }}">
                <label>Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="form-control" value="{{ $transaksi->tanggal_kembali ?? date('Y-m-d') }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
<script>
function toggleKembali() {
    var status = document.getElementById('status').value;
    var tglDiv = document.getElementById('tgl_kembali_div');
    if(status == 'kembali') {
        tglDiv.style.display = 'block';
    } else {
        tglDiv.style.display = 'none';
    }
}
</script>
@endsection
