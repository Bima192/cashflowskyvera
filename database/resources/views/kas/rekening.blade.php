@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Manajemen Rekening</h3>
            <p class="text-muted-custom mb-0">Kelola rekening bank dan kas Anda</p>
        </div>
        <button class="btn btn-primary-custom rounded-3 py-2 px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRekening">
            <i class="bi bi-plus-lg me-2"></i> Tambah Rekening
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($rekenings->isEmpty())
        <div class="card rounded-4 border-0 shadow-sm p-5 text-center">
            <i class="bi bi-bank fs-1 text-primary mb-3"></i>
            <h5 class="fw-bold">Belum Ada Rekening</h5>
            <p class="text-muted-custom">Tambahkan rekening bank atau kas Anda untuk mulai mengelola keuangan.</p>
            <div>
                <button class="btn btn-primary-custom rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#modalRekening">
                    Tambah Rekening Baru
                </button>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($rekenings as $rekening)
                <div class="col-md-4">
                    <div class="card rounded-4 border-0 shadow-sm p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-bank2 fs-4"></i>
                            </div>
                            <form action="{{ route('kas.rekening.destroy', $rekening->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus rekening {{ $rekening->nama }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger bg-danger bg-opacity-10 border-0 rounded-3">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $rekening->nama }}</h5>
                        @if($rekening->bank)
                            <div class="text-muted-custom mb-1"><i class="bi bi-building me-1"></i> {{ $rekening->bank }}</div>
                        @endif
                        @if($rekening->nomor_rekening)
                            <div class="text-muted-custom"><i class="bi bi-credit-card me-1"></i> {{ $rekening->nomor_rekening }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Modal Tambah Rekening --}}
    <div class="modal fade" id="modalRekening" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark">Tambah Rekening Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('kas.rekening.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted-custom fw-bold">Nama Rekening</label>
                            <input type="text" name="nama" class="form-control rounded-3 p-2 bg-light border-0 shadow-none"
                                   placeholder="Cth: BCA Utama, Kas Tunai" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted-custom fw-bold">Nama Bank <span class="text-muted fw-normal">(opsional)</span></label>
                            <input type="text" name="bank" class="form-control rounded-3 p-2 bg-light border-0 shadow-none"
                                   placeholder="Cth: BCA, BNI, Mandiri">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted-custom fw-bold">Nomor Rekening <span class="text-muted fw-normal">(opsional)</span></label>
                            <input type="text" name="nomor_rekening" class="form-control rounded-3 p-2 bg-light border-0 shadow-none"
                                   placeholder="Cth: 1234567890">
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-3 py-3 fw-bold">Simpan Rekening</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection