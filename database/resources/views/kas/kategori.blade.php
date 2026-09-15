@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Manajemen Kategori</h3>
            <p class="text-muted-custom mb-0">Atur label pendapatan dan pengeluaran</p>
        </div>
        <button class="btn btn-primary-custom rounded-3 py-2 px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalKategori">
            <i class="bi bi-plus-lg me-2"></i> Kategori Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card rounded-4 border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4 text-success"><i class="bi bi-arrow-down-circle me-2"></i> Kategori Pemasukan</h5>
                @if($pemasukanList->isEmpty())
                    <p class="text-muted-custom text-center py-3">Belum ada kategori pemasukan.</p>
                @else
                    <ul class="list-group list-group-flush gap-2">
                        @foreach($pemasukanList as $kategori)
                            <li class="list-group-item d-flex justify-content-between align-items-center border bg-light rounded-3">
                                <span class="fw-medium">{{ $kategori->nama }}</span>
                                <div>
                                    <form action="{{ route('kas.kategori.destroy', $kategori->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus kategori {{ $kategori->nama }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border-0">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="card rounded-4 border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4 text-danger"><i class="bi bi-arrow-up-circle me-2"></i> Kategori Pengeluaran</h5>
                @if($pengeluaranList->isEmpty())
                    <p class="text-muted-custom text-center py-3">Belum ada kategori pengeluaran.</p>
                @else
                    <ul class="list-group list-group-flush gap-2">
                        @foreach($pengeluaranList as $kategori)
                            <li class="list-group-item d-flex justify-content-between align-items-center border bg-light rounded-3">
                                <span class="fw-medium">{{ $kategori->nama }}</span>
                                <div>
                                    <form action="{{ route('kas.kategori.destroy', $kategori->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus kategori {{ $kategori->nama }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border-0">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Tambah Kategori --}}
    <div class="modal fade" id="modalKategori" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('kas.kategori.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted-custom fw-bold">Jenis Kategori</label>
                            <select name="jenis" class="form-select rounded-3 p-2 bg-light border-0 shadow-none" required>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted-custom fw-bold">Nama Kategori</label>
                            <input type="text" name="nama" class="form-control rounded-3 p-2 bg-light border-0 shadow-none"
                                   placeholder="Cth: Starlink, Gaji, Server" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-3 py-3 fw-bold">Simpan Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection