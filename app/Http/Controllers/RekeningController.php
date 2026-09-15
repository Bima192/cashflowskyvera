<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekeningController extends Controller
{
    public function index(): View
    {
        $rekenings = Rekening::orderBy('nama')->get();

        return view('kas.rekening', compact('rekenings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_rekening' => 'nullable|string|max:100',
            'bank' => 'nullable|string|max:100',
        ]);

        Rekening::create($request->only('nama', 'nomor_rekening', 'bank'));

        return redirect()->route('kas.rekening')->with('success', 'Rekening berhasil ditambahkan!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $rekening = Rekening::findOrFail($id);
        $rekening->delete();

        return redirect()->route('kas.rekening')->with('success', 'Rekening berhasil dihapus!');
    }
}
