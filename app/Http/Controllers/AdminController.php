<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Transaksi;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Buku CRUD
    public function indexBuku()
    {
        $buku = Buku::all();
        return view('admin.buku.index', compact('buku'));
    }

    public function createBuku()
    {
        return view('admin.buku.create');
    }

    public function storeBuku(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|unique:buku,kode_buku',
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
        ]);

        Buku::create($validated);
        return redirect()->route('admin.buku')->with('success', 'Buku added successfully');
    }

    public function editBuku($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku'));
    }

    public function updateBuku(Request $request, $id)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|unique:buku,kode_buku,'.$id.',id_buku',
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($validated);
        return redirect()->route('admin.buku')->with('success', 'Buku updated successfully');
    }

    public function destroyBuku($id)
    {
        Buku::destroy($id);
        return redirect()->route('admin.buku')->with('success', 'Buku deleted successfully');
    }

    // Anggota CRUD
    public function indexAnggota()
    {
        $anggota = Anggota::all();
        return view('admin.anggota.index', compact('anggota'));
    }

    public function createAnggota()
    {
        return view('admin.anggota.create');
    }

    public function storeAnggota(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:anggota,nis',
            'nama_anggota' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'username' => 'required|unique:anggota,username',
            'password' => 'required|min:4',
        ]);
        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        Anggota::create($validated);
        return redirect()->route('admin.anggota')->with('success', 'Anggota added successfully');
    }
    
    public function editAnggota($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function updateAnggota(Request $request, $id)
    {
         $validated = $request->validate([
            'nis' => 'required|unique:anggota,nis,'.$id.',id_anggota',
            'nama_anggota' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'username' => 'required|unique:anggota,username,'.$id.',id_anggota',
        ]);
        
        $anggota = Anggota::findOrFail($id);
        if($request->filled('password')) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $anggota->update($validated);
        return redirect()->route('admin.anggota')->with('success', 'Anggota updated successfully');
    }

    public function destroyAnggota($id)
    {
        Anggota::destroy($id);
        return redirect()->route('admin.anggota')->with('success', 'Anggota deleted successfully');
    }

    // Transaksi CRUD
    public function indexTransaksi()
    {
        $transaksi = Transaksi::with(['anggota', 'buku'])->get();
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function createTransaksi()
    {
        $anggota = Anggota::all();
        $buku = Buku::where('stok', '>', 0)->get();
        return view('admin.transaksi.create', compact('anggota', 'buku'));
    }

    public function storeTransaksi(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
        ]);

        // Reduce stock
        $buku = Buku::find($validated['id_buku']);
        if($buku->stok <= 0) {
            return back()->withErrors(['msg' => 'Stok buku habis']);
        }
        $buku->decrement('stok');

        $validated['status'] = 'pinjam';
        Transaksi::create($validated);
        
        return redirect()->route('admin.transaksi')->with('success', 'Transaksi created');
    }

    public function editTransaksi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
         $anggota = Anggota::all();
        $buku = Buku::all();
        return view('admin.transaksi.edit', compact('transaksi', 'anggota', 'buku'));
    }

    public function updateTransaksi(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        if ($request->status == 'kembali' && $transaksi->status == 'pinjam') {
             $request->validate(['tanggal_kembali' => 'required|date']);
             $transaksi->update([
                 'status' => 'kembali',
                 'tanggal_kembali' => $request->tanggal_kembali
             ]);
             $transaksi->buku->increment('stok');
        } else {
             $transaksi->update($request->only(['tanggal_pinjam', 'tanggal_kembali', 'status']));
        }

        return redirect()->route('admin.transaksi')->with('success', 'Transaksi updated');
    }
    
    public function destroyTransaksi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('admin.transaksi')->with('success', 'Transaksi deleted');
    }
}
