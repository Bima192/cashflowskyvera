@extends('layouts.app')

@section('content')
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius: 12px;" role="alert">
            <i class="bi bi-check-circle-fill me-2 text-success"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header Row --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Dashboard</h2>
            <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Ringkasan arus kas bisnis Anda — <strong>{{ $namaBulan }}</strong></p>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- Filter Bulan & Tahun --}}
            <form action="{{ route('kas.index') }}" method="GET" class="d-flex align-items-center gap-2 bg-white border rounded-3 px-3 py-2 shadow-sm" style="border-color: #e2e8f0 !important;">
                <i class="bi bi-calendar3 text-muted" style="font-size: 0.85rem;"></i>
                <select name="bulan" class="border-0 shadow-none fw-medium text-dark bg-transparent" style="outline:none; font-size: 0.875rem; cursor:pointer;" onchange="this.form.submit()">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == sprintf('%02d', $i) ? 'selected' : '' }}>
                            {{ Carbon\Carbon::createFromDate(null, $i, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <span style="color: #cbd5e1;">|</span>
                <select name="tahun" class="border-0 shadow-none fw-medium text-dark bg-transparent" style="outline:none; font-size: 0.875rem; cursor:pointer;" onchange="this.form.submit()">
                    @for($y = 2024; $y <= 2030; $y++)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
            <button class="btn btn-primary-custom px-4 py-2 fw-semibold" style="font-size: 0.875rem;" data-bs-toggle="modal" data-bs-target="#modalTransaksi">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background: #ecfdf5; color: #10b981;">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </div>
                    <span style="font-size: 0.7rem; background: #ecfdf5; color: #059669; padding: 3px 10px; border-radius: 20px; font-weight: 600;">Masuk</span>
                </div>
                <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 500; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total Pemasukan</div>
                <div style="font-size: 1.3rem; font-weight: 700; color: #10b981;">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background: #fef2f2; color: #ef4444;">
                        <i class="bi bi-arrow-up-circle-fill"></i>
                    </div>
                    <span style="font-size: 0.7rem; background: #fef2f2; color: #dc2626; padding: 3px 10px; border-radius: 20px; font-weight: 600;">Keluar</span>
                </div>
                <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 500; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total Pengeluaran</div>
                <div style="font-size: 1.3rem; font-weight: 700; color: #ef4444;">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); border-color: transparent;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background: rgba(255,255,255,0.15); color: #fff;">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <span style="font-size: 0.7rem; background: rgba(255,255,255,0.2); color: #fff; padding: 3px 10px; border-radius: 20px; font-weight: 600;">Saldo</span>
                </div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); font-weight: 500; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Saldo Akhir</div>
                <div style="font-size: 1.3rem; font-weight: 700; color: #fff;">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background: #faf5ff; color: #8b5cf6;">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>
                    <span style="font-size: 0.7rem; background: #faf5ff; color: #7c3aed; padding: 3px 10px; border-radius: 20px; font-weight: 600;">Total</span>
                </div>
                <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 500; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Jumlah Transaksi</div>
                <div style="font-size: 1.3rem; font-weight: 700; color: #0f172a;">{{ $transaksi->count() }} <span style="font-size: 0.85rem; color: #94a3b8; font-weight: 400;">transaksi</span></div>
            </div>
        </div>
    </div>

    {{-- Chart + Transaksi Terbaru --}}
    <div class="row g-4">
        {{-- Grafik --}}
        <div class="col-lg-8">
            <div class="card-modern p-4" style="border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="fw-bold mb-0" style="color: #0f172a;">Grafik Arus Kas Harian</h6>
                        <div style="font-size: 0.8rem; color: #94a3b8;">{{ $namaBulan }}</div>
                    </div>
                    <div class="d-flex gap-3" style="font-size: 0.75rem; font-weight: 600;">
                        <span><span style="display:inline-block; width:10px; height:10px; background:#10b981; border-radius:50%; margin-right:5px;"></span>Pemasukan</span>
                        <span><span style="display:inline-block; width:10px; height:10px; background:#ef4444; border-radius:50%; margin-right:5px;"></span>Pengeluaran</span>
                    </div>
                </div>
                <div style="position: relative; height: 260px;">
                    <canvas id="chartArusKas"></canvas>
                </div>
            </div>
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="col-lg-4">
            <div class="card-modern p-4 d-flex flex-column" style="height: 100%;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="color: #0f172a;">Transaksi Terbaru</h6>
                    <a href="{{ route('kas.transaksi') }}" style="font-size: 0.8rem; color: #4f46e5; font-weight: 600; text-decoration: none;">Lihat Semua →</a>
                </div>
                <div style="overflow-y: auto; flex: 1;">
                    @forelse($transaksi->take(8) as $trx)
                        <div class="d-flex align-items-center gap-3 py-2" style="border-bottom: 1px solid #f1f5f9;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
                                background: {{ $trx->jenis == 'pemasukan' ? '#ecfdf5' : '#fef2f2' }};
                                color: {{ $trx->jenis == 'pemasukan' ? '#10b981' : '#ef4444' }};">
                                <i class="bi bi-{{ $trx->jenis == 'pemasukan' ? 'arrow-down-short' : 'arrow-up-short' }} fs-5"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="fw-semibold text-truncate" style="font-size: 0.825rem; color: #1e293b;">{{ $trx->kategori }}</div>
                                <div style="font-size: 0.72rem; color: #94a3b8;">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</div>
                            </div>
                            <div style="font-size: 0.8rem; font-weight: 700; color: {{ $trx->jenis == 'pemasukan' ? '#10b981' : '#ef4444' }}; white-space: nowrap;">
                                {{ $trx->jenis == 'pemasukan' ? '+' : '-' }}{{ number_format($trx->nominal / 1000) }}k
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4" style="color: #94a3b8; font-size: 0.85rem;">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada transaksi
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Transaksi --}}
    <div class="modal fade" id="modalTransaksi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header px-4 pt-4 pb-3">
                    <h5 class="modal-title fw-bold" style="color: #0f172a;">Tambah Transaksi Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <form action="{{ route('kas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Jenis Transaksi</label>
                            <div class="d-flex gap-2">
                                <label class="flex-fill text-center border rounded-3 py-2 px-3 fw-semibold" style="cursor:pointer; font-size: 0.875rem;" id="labelMasuk">
                                    <input type="radio" name="jenis" value="pemasukan" class="d-none" required> <i class="bi bi-arrow-down-circle me-1 text-success"></i> Masuk
                                </label>
                                <label class="flex-fill text-center border rounded-3 py-2 px-3 fw-semibold" style="cursor:pointer; font-size: 0.875rem;" id="labelKeluar">
                                    <input type="radio" name="jenis" value="pengeluaran" class="d-none"> <i class="bi bi-arrow-up-circle me-1 text-danger"></i> Keluar
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->nama }}">{{ $kat->nama }}</option>
                                @endforeach
                                @if($kategoris->isEmpty())
                                    <option value="Lain-lain">Lain-lain</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Nominal (Rp)</label>
                            <input type="number" name="nominal" class="form-control fw-bold" style="font-size: 1.1rem; color: #4f46e5;" placeholder="0" min="0" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold">
                            <i class="bi bi-check-lg me-2"></i> Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Radio button styling
    document.querySelectorAll('input[name="jenis"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('labelMasuk').style.background = '';
            document.getElementById('labelMasuk').style.borderColor = '';
            document.getElementById('labelKeluar').style.background = '';
            document.getElementById('labelKeluar').style.borderColor = '';

            if (this.value === 'pemasukan') {
                document.getElementById('labelMasuk').style.background = '#ecfdf5';
                document.getElementById('labelMasuk').style.borderColor = '#10b981';
            } else {
                document.getElementById('labelKeluar').style.background = '#fef2f2';
                document.getElementById('labelKeluar').style.borderColor = '#ef4444';
            }
        });
    });

    // Chart.js - Perbandingan Arus Kas
    const ctx = document.getElementById('chartArusKas').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pemasukan', 'Pengeluaran'],
            datasets: [{
                data: [{{ $pendapatan }}, {{ $pengeluaran }}],
                backgroundColor: ['rgba(16, 185, 129, 0.85)', 'rgba(239, 68, 68, 0.8)'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { 
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 13, weight: '600' },
                        color: '#475569',
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map(function(label, i) {
                                    const value = data.datasets[0].data[i];
                                    return {
                                        text: label + ': Rp ' + value.toLocaleString('id-ID'),
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        hidden: false,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ' Rp ' + ctx.parsed.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

</script>
@endsection