@extends('layouts.default')

@section('content')
@section('title', 'Users - Data Users')
<div class="card">
    <h5 class="card-header">Data Users</h5>
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
            <th>email</th>
            <th>region</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($items as $item)
          <tr>
            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>
                @if(is_null($item->region_id))
                    <span class="badge bg-label-secondary">Tidak ada region</span>
                @elseif($item->region)
                    <!-- Region ada -->
                    <span class="badge bg-label-success">{{ $item->region->name }}</span>
                @else
                    <!-- Region dihapus atau tidak ditemukan -->
                    <span class="badge bg-label-danger">Region dihapus (ID: {{ $item->region_id }})</span>
                @endif
            </td>
            <td>
              <a href="{{ route('user.show', $item->uuid) }}" class="btn btn-success btn-sm">
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