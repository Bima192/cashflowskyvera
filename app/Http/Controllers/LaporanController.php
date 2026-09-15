<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        return view('kas.laporan');
    }

    public function exportPdf(Request $request): Response
    {
        $bulan = $request->get('bulan', Carbon::now()->format('m'));
        $tahun = $request->get('tahun', Carbon::now()->format('Y'));

        $transaksi = Transaction::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $pendapatan = $transaksi->where('jenis', 'pemasukan')->sum('nominal');
        $pengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $pendapatan - $pengeluaran;

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('kas.laporan-pdf', compact(
            'transaksi',
            'pendapatan',
            'pengeluaran',
            'saldo',
            'bulan',
            'tahun',
            'namaBulan'
        ))->setPaper('a4');

        return $pdf->download("laporan-{$namaBulan}-{$tahun}.pdf");
    }

    public function exportExcel(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $bulan = $request->get('bulan', Carbon::now()->format('m'));
        $tahun = $request->get('tahun', Carbon::now()->format('Y'));

        $transaksi = Transaction::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');

        return response()->streamDownload(function () use ($transaksi) {
            $handle = fopen('php://output', 'w');

            // BOM untuk UTF-8 agar terbaca Excel
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['Tanggal', 'Kategori', 'Jenis', 'Nominal'], ';');

            foreach ($transaksi as $trx) {
                fputcsv($handle, [
                    Carbon::parse($trx->tanggal)->format('d/m/Y'),
                    $trx->kategori,
                    ucfirst($trx->jenis),
                    $trx->nominal,
                ], ';');
            }

            fclose($handle);
        }, "laporan-{$namaBulan}-{$tahun}.csv");
    }

    public function exportTahunanPdf(Request $request): Response
    {
        $tahun = $request->get('tahun', Carbon::now()->format('Y'));

        $transaksi = Transaction::whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $pendapatan = $transaksi->where('jenis', 'pemasukan')->sum('nominal');
        $pengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $pendapatan - $pengeluaran;

        $pdf = Pdf::loadView('kas.laporan-tahunan-pdf', compact(
            'transaksi',
            'pendapatan',
            'pengeluaran',
            'saldo',
            'tahun'
        ))->setPaper('a4');

        return $pdf->download("laporan-tahunan-{$tahun}.pdf");
    }

    public function exportTahunanExcel(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $tahun = $request->get('tahun', Carbon::now()->format('Y'));

        $transaksi = Transaction::whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        return response()->streamDownload(function () use ($transaksi) {
            $handle = fopen('php://output', 'w');

            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['Tanggal', 'Kategori', 'Jenis', 'Nominal'], ';');

            foreach ($transaksi as $trx) {
                fputcsv($handle, [
                    Carbon::parse($trx->tanggal)->format('d/m/Y'),
                    $trx->kategori,
                    ucfirst($trx->jenis),
                    $trx->nominal,
                ], ';');
            }

            fclose($handle);
        }, "laporan-tahunan-{$tahun}.csv");
    }
}
