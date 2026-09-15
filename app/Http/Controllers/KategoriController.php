<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategoris = Kategori::orderBy('jenis')->orderBy('nama')->get();
        $pemasukanList = $kategoris->where('jenis', 'pemasukan');
        $pengeluaranList = $kategoris->where('jenis', 'pengeluaran');

        return view('kas.kategori', compact('pemasukanList', 'pengeluaranList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
        ]);

        Kategori::create($request->only('nama', 'jenis'));

        return redirect()->route('kas.kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kas.kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
