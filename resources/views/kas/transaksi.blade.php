@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Semua Transaksi</h3>
            <p class="text-muted-custom mb-0">Riwayat seluruh pemasukan dan pengeluaran</p>
        </div>
        <button class="btn btn-primary-custom rounded-3 py-2 px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTransaksi">
            <i class="bi bi-plus-lg me-2"></i> Tambah Baru
        </button>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card rounded-4 border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle mb-0">
                <thead class="bg-light text-muted-custom" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 py-3 fw-medium">Tanggal</th>
                        <th class="py-3 fw-medium">Kategori</th>
                        <th class="py-3 fw-medium">Jenis</th>
                        <th class="text-end py-3 fw-medium">Jumlah</th>
                        <th class="text-center pe-4 py-3 fw-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $trx)
                    <tr class="border-bottom">
                        <td class="ps-4 py-3 text-muted-custom">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                        <td class="fw-bold text-dark py-3">
                            @if($trx->jenis == 'pemasukan')
                                <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle me-2" style="width: 28px; height: 28px;"><i class="bi bi-arrow-down-short fs-5"></i></div>
                            @else
                                <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle me-2" style="width: 28px; height: 28px;"><i class="bi bi-lightning-charge-fill" style="font-size: 0.8rem;"></i></div>
                            @endif
                            {{ $trx->kategori }}
                        </td>
                        <td class="py-3">
                            @if($trx->jenis == 'pemasukan')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fw-medium">Masuk</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2 fw-medium">Keluar</span>
                            @endif
                        </td>
                        <td class="text-end fw-bold py-3 {{ $trx->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                            {{ $trx->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                        </td>
                        <td class="text-center pe-4 py-3">
                            <form action="{{ route('kas.destroy', $trx->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi {{ $trx->kategori }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger bg-danger bg-opacity-10 border-0 rounded-3 px-2 py-1" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada transaksi sama sekali.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form (Bisa dipanggil di halaman ini juga) -->
    <div class="modal fade" id="modalTransaksi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark">Tambah Transaksi</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('kas.store') }}" method="POST">
                        @csrf
                        <!-- Isi form disingkat agar fokus, pastikan isiannya sama persis dengan yang ada di dashboard -->
                        <div class="mb-3">
                            <label class="form-label text-muted-custom fw-bold">Jenis Transaksi</label>
                            <select name="jenis" class="form-select rounded-3 p-2 bg-light border-0 shadow-none" required>
                                <option value="pemasukan">Masuk (Pendapatan)</option>
                                <option value="pengeluaran">Keluar (Pengeluaran)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted-custom fw-bold">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control rounded-3 p-2 bg-light border-0 shadow-none" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted-custom fw-bold">Kategori</label>
                            <input type="text" name="kategori" class="form-control rounded-3 p-2 bg-light border-0 shadow-none" placeholder="Cth: Starlink, Server" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted-custom fw-bold">Nominal (Rp)</label>
                            <input type="number" name="nominal" class="form-control rounded-3 p-2 bg-light border-0 shadow-none fs-5 fw-bold text-primary" placeholder="0" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-3 py-3 fw-bold">Simpan Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection