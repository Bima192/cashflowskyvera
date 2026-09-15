<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $bulan = $request->get('bulan', Carbon::now()->format('m'));
        $tahun = $request->get('tahun', Carbon::now()->format('Y'));

        $transaksi = Transaction::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        $pendapatan = $transaksi->where('jenis', 'pemasukan')->sum('nominal');
        $pengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $pendapatan - $pengeluaran;
        $kategoris = Kategori::orderBy('nama')->get();

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');

        return view('kas.index', compact(
            'transaksi',
            'pendapatan',
            'pengeluaran',
            'saldo',
            'bulan',
            'tahun',
            'kategoris',
            'namaBulan'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
        ]);

        Transaction::create($request->only('tanggal', 'jenis', 'kategori', 'nominal'));

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $transaksi = Transaction::findOrFail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Data transaksi berhasil dihapus!');
    }

    public function transaksi(): View
    {
        $transaksi = Transaction::orderBy('tanggal', 'desc')->get();
        $kategoris = Kategori::orderBy('nama')->get();

        return view('kas.transaksi', compact('transaksi', 'kategoris'));
    }
}