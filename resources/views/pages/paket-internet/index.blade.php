@extends('layouts.default')

@section('content')
<div class="card">
    <h5 class="card-header">Data Paket Internet</h5>
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
            <th>category</th>
            <th>speed</th>
            <th>ideal device</th>
            <th>pemasangan</th>
            <th>bulanan</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($items as $item)
          <tr>
            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
            <td>
              @if ($item->image)
                  <img width="50" src="{{ $item->image }}" alt="">
              @endif
            </td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->category }}</td>
            <td>{{ $item->speed }}</td>
            <td>{{ $item->ideal_device }}</td>
            <td>Rp. {{ number_format($item->installation, 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($item->monthly_bill, 0, ',', '.') }}</td>
            <td>
              {{-- <a href="" class="btn btn-success btn-sm">
                <i class='bx bx-show'></i>
              </a> --}}
              <a href="{{ route('internet-package.edit', $item->id) }}" class="btn btn-info btn-sm">
                <i class="bx bx-edit"></i>
              </a>
              <form action="{{ route('internet-package.destroy', $item->id) }}" 
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