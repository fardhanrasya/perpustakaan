<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Transaksi;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function dashboard()
    {
        return view('siswa.dashboard');
    }

    public function indexPeminjaman()
    {
        $buku = Buku::where('stok', '>', 0)->get();
        return view('siswa.peminjaman.index', compact('buku'));
    }

    public function storePeminjaman(Request $request)
    {
        $validated = $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
        ]);

        $buku = Buku::find($validated['id_buku']);
        if($buku->stok <= 0) {
             return back()->withErrors(['msg' => 'Stok buku habis']);
        }

        $buku->decrement('stok');

        Transaksi::create([
            'id_anggota' => Auth::guard('anggota')->id(),
            'id_buku' => $validated['id_buku'],
            'tanggal_pinjam' => Carbon::now(),
            'status' => 'pinjam',
        ]);

        return redirect()->route('siswa.peminjaman')->with('success', 'Buku berhasil dipinjam');
    }

    public function indexPengembalian()
    {
        $transaksi = Transaksi::with('buku')
            ->where('id_anggota', Auth::guard('anggota')->id())
            ->where('status', 'pinjam')
            ->get();
            
        return view('siswa.pengembalian.index', compact('transaksi'));
    }

    public function storePengembalian(Request $request)
    {
        $validated = $request->validate([
            'id_transaksi' => 'required|exists:transaksi,id_transaksi',
        ]);
        
        $transaksi = Transaksi::where('id_transaksi', $validated['id_transaksi'])
            ->where('id_anggota', Auth::guard('anggota')->id())
            ->where('status', 'pinjam')
            ->firstOrFail();

        $transaksi->update([
            'status' => 'kembali',
            'tanggal_kembali' => Carbon::now(),
        ]);
        
        $transaksi->buku->increment('stok');

        return redirect()->route('siswa.pengembalian')->with('success', 'Buku berhasil dikembalikan');
    }
}
