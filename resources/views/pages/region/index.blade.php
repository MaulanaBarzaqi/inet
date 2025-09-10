@extends('layouts.default')

@section('content')
@section('title', 'Region - Data Region')
<div class="card">
    <h5 class="card-header">Data Region</h5>
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
            <th>image</th>
            <th>name</th>
            <th>location</th>
            <th>Jumlah User</th>
            <th>Description</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($items as $item)
          <tr>
            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
            <td>
              @if ($item->image)
                {{-- <div>{{ asset('storage/' . $item->image) }}</div> --}}
                <img width="50" src="{{ asset('storage/' . $item->image) }}" alt="">
              @else
                <span class="text-muted">tidak ada foto</span>
              @endif
            </td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->location }}</td>
            <td>
               <span class="badge bg-primary">
                  {{ $item->non_admin_users_count }} user
               </span>
            </td>
            <td>
                @if(strlen($item->description) > 30)
                    {{ substr($item->description, 0, 30) }}...
                @else
                    {{ $item->description }}
                @endif
            </td>
            <td>
              <a href="{{ route('region.show', $item->slug) }}" class="btn btn-success btn-sm">
                <i class='bx bx-show'></i>
              </a>
              <a href="{{ route('region.edit', $item->slug) }}" class="btn btn-info btn-sm">
                <i class="bx bx-edit"></i>
              </a>
              <form action="{{ route('region.destroy', $item->slug) }}" 
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