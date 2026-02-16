@extends('layouts.default')
@section('title', 'Notifikasi - Laporan Notifikasi')

@section('content')
    <div class="card">
        <h5 class="card-header">Laporan Notifikasi</h5>
        <div class="table-responsive text-nowrap p-3">
            <form method="GET" action="{{ route('notifications.report') }}" id="filter-form">
                <div class="d-flex justify-content-between align-items-end mb-4">

                    <div class="search-wrapper">
                        <div class="d-flex">
                            <input class="form-control me-2" name="search" value="{{ request('search') }}" type="search" placeholder="Search..." />
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div>
                            <label class="form-label">Bulan</label>
                            <input class="form-control" type="month" name="month" value="{{ request('month') }}" />
                        </div>
                        <div>
                            <label class="form-label">Minggu</label>
                            <input class="form-control" type="week" name="week" value="{{ request('week') }}" />
                        </div>
                        <div class="align-self-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-filter-alt"></i> Filter
                            </button>

                            <button type="submit" formaction="{{ route('notifications.report.pdf') }}" formtarget="_blank" class="btn btn-danger">
                                <i class="bx bxs-file-pdf"></i> Export PDF
                            </button>

                            <a href="{{ route('notifications.report') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
            <table class="table mb-3">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Target</th>
                    <th>Kategori</th>
                    <th>Isi Pesan</th>
                    <th>Jumlah Terkirim</th>
                    <th>Waktu Kirim</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($logs as $log)
                         <tr>
                            <td>{{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}</td>
                            <td>
                                @if($log->target_type == 'all')
                                    <span class="badge bg-label-secondary">Semua Pelanggan</span>
                                @else
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ ucfirst($log->target_type) }}</span>
                                        <small class="text-muted">{{ $log->data_payload['target_name'] ?? 'N/A' }}</small>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($log->category == 'general')
                                    <span class="badge bg-label-info">Umum / Broadcast</span>
                                @else
                                    <span class="badge bg-label-success">Update Status</span>
                                @endif
                            </td>
                            <td>
                                <div style="max-width: 300px; white-space: normal;">
                                    <strong>{{ $log->title }}</strong><br>
                                    <small>{{ Str::limit($log->body, 100) }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold">{{ number_format($log->total_sent) }}</span>
                            </td>
                            <td>
                                {{ $log->created_at->translatedFormat('d M Y') }}<br>
                                <small class="text-muted">{{ $log->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <form action="{{ route('notifications.destroy', $log->id) }}" 
                                    method="post" 
                                    class="d-inline">
                                  @csrf
                                  @method('delete')
                                  <button class="btn btn-danger btn-sm">
                                    <i class="bx bx-trash"></i>
                                  </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data notifikasi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
  </div>
@endsection