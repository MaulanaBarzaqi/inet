@extends('layouts.default')

@section('content')
@section('title', 'Pemasangan - Data Pemasangan Internet')
<div class="card">
    <h5 class="card-header">Data Pemasangan Internet</h5>
    <div class="table-responsive text-nowrap p-3">
      <div class="d-flex justify-content-start mb-4">
        <form class="d-flex" method="GET" action="">
          <input class="form-control me-2" name="search" value="" type="search" placeholder="Search" aria-label="Search" />
          <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
      </div>
      <table class="table mb-3">
        <thead>
          <tr>
            <th>#</th>
            <th>nama</th>
            <th>WhatsApp</th>
            <th>Alamat</th>
            <th>Paket Internet</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($items as $item)
          <tr>
            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->address }}</td>
            <td>
              @if(is_null($item->internet_package_id))
                    <span class="badge bg-label-secondary">Tidak ada paket internet</span>
                @elseif($item->internetPackage)
                    <!-- paket ada -->
                    {{ $item->internetPackage->name }}
                @else
                    <!-- Region dihapus atau tidak ditemukan -->
                    <span class="badge bg-label-danger">Paket internet dihapus (ID: {{ $item->internet_package_id }})</span>
                @endif
            </td>
            <td>
              @if ($item->status == 'pending')
                <span class="badge bg-label-warning">
              @elseif ($item->status == 'approved')
                <span class="badge bg-label-success">
              @elseif ($item->status == 'rejected')
                <span class="badge bg-label-danger">
              @else
                </span>
              @endif
                {{ $item->status }}
                </span>
            </td>
            <td>
              <a href="{{ route('internet-installation.show', $item->uuid) }}" class="btn btn-success btn-sm">
                <i class='bx bx-show'></i>
              </a>
              <form action="" 
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
                <td colspan="12" class="text-center p-5">
                  Data tidak tersedia
                </td>
              </tr>
          @endforelse
        </tbody>
      </table>
      {!! $items->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
  </div>
@endsection