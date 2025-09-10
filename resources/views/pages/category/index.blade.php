@extends('layouts.default')

@section('content')
@section('title', 'Categories - Data Category')
<div class="card">
    <h5 class="card-header">Data Category</h5>
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
            <th>Description</th>
            <th>jumlah paket internet</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($items as $item)
          <tr>
            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>
                @if(strlen($item->description) > 40)
                    {{ substr($item->description, 0, 40) }}...
                @else
                    {{ $item->description }}
                @endif
            </td>
            <td>
                <span class="badge bg-primary">
                    {{ $item->internet_packages_count }} paket
                </span>
            </td>
            <td>
              <a href="{{ route('category.edit', $item->slug) }}" class="btn btn-info btn-sm">
                <i class="bx bx-edit"></i>
              </a>
              <form action="{{ route('category.destroy', $item->slug) }}" 
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