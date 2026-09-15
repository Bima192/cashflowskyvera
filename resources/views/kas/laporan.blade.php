@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-1 text-dark">Laporan Keuangan</h3>
    <p class="text-muted-custom mb-4">Ekspor dan unduh ringkasan transaksi Anda</p>

    <div class="row g-4">
        {{-- Laporan Bulanan --}}
        <div class="col-md-4">
            <div class="card rounded-4 border-0 shadow-sm p-4 text-center h-100">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-calendar-month fs-3"></i>
                </div>
                <h5 class="fw-bold">Laporan Bulanan</h5>
                <p class="text-muted-custom" style="font-size: 0.85rem;">Unduh rekapitulasi arus kas berdasarkan bulan tertentu.</p>

                <form id="formBulanan" class="mt-auto pt-3">
                    <div class="input-group mb-3">
                        <select name="bulan" class="form-select bg-light border-0" id="pilihBulan">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ sprintf('%02d', $i) }}" {{ now()->format('m') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                    {{ Carbon\Carbon::createFromDate(null, $i, 1)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                        <select name="tahun" class="form-select bg-light border-0" id="pilihTahun">
                            @for($y = 2024; $y <= 2030; $y++)
                                <option value="{{ $y }}" {{ now()->format('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <a id="btnPdfBulanan" href="#" class="btn btn-outline-primary w-100 rounded-3 mb-2">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Download PDF
                    </a>
                    <a id="btnExcelBulanan" href="#" class="btn btn-outline-success w-100 rounded-3">
                        <i class="bi bi-file-earmark-excel me-2"></i> Download Excel
                    </a>
                </form>
            </div>
        </div>

        {{-- Laporan Tahunan --}}
        <div class="col-md-4">
            <div class="card rounded-4 border-0 shadow-sm p-4 text-center h-100">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-calendar3 fs-3"></i>
                </div>
                <h5 class="fw-bold">Laporan Tahunan</h5>
                <p class="text-muted-custom" style="font-size: 0.85rem;">Ringkasan total pendapatan dan pengeluaran sepanjang tahun.</p>

                <form id="formTahunan" class="mt-auto pt-3">
                    <div class="mb-3">
                        <select name="tahun" class="form-select bg-light border-0" id="pilihTahunTahunan">
                            @for($y = 2024; $y <= 2030; $y++)
                                <option value="{{ $y }}" {{ now()->format('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <a id="btnPdfTahunan" href="#" class="btn btn-outline-primary w-100 rounded-3 mb-2">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Download PDF
                    </a>
                    <a id="btnExcelTahunan" href="#" class="btn btn-outline-success w-100 rounded-3">
                        <i class="bi bi-file-earmark-excel me-2"></i> Download Excel
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const pdfBulananBase = "{{ route('kas.laporan.pdf') }}";
    const excelBulananBase = "{{ route('kas.laporan.excel') }}";
    const pdfTahunanBase = "{{ route('kas.laporan.pdf.tahunan') }}";
    const excelTahunanBase = "{{ route('kas.laporan.excel.tahunan') }}";

    function updateBulananLinks() {
        const bulan = document.getElementById('pilihBulan').value;
        const tahun = document.getElementById('pilihTahun').value;
        document.getElementById('btnPdfBulanan').href = pdfBulananBase + '?bulan=' + bulan + '&tahun=' + tahun;
        document.getElementById('btnExcelBulanan').href = excelBulananBase + '?bulan=' + bulan + '&tahun=' + tahun;
    }

    function updateTahunanLinks() {
        const tahun = document.getElementById('pilihTahunTahunan').value;
        document.getElementById('btnPdfTahunan').href = pdfTahunanBase + '?tahun=' + tahun;
        document.getElementById('btnExcelTahunan').href = excelTahunanBase + '?tahun=' + tahun;
    }

    document.getElementById('pilihBulan').addEventListener('change', updateBulananLinks);
    document.getElementById('pilihTahun').addEventListener('change', updateBulananLinks);
    document.getElementById('pilihTahunTahunan').addEventListener('change', updateTahunanLinks);

    // Init links on load
    updateBulananLinks();
    updateTahunanLinks();
</script>
@endsection