@extends('layouts.default')

@section('content')
@section('title', 'Region - Detail Region')
     <div class="card mb-4">
         <h5 class="card-header">Region Detail</h5>

         <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-4">
             @if ($item->image)
                  <img width="100" src="{{ asset('storage/' . $item->image) }}" alt="">
              @else
                   <div class="d-flex align-items-center justify-content-center border rounded" 
                        style="width: 100px; height: 100px; background-color: #f8f9fa;">
                        <i class='bx bx-image-alt fs-1 text-muted'></i>
                    </div>
              @endif
          </div>
        </div>

         <hr class="my-0" />
         <div class="card-body">
             <div class="table-responsive text-nowrap">
                 <table class="table table-bordered">
                     <tr>
                         <th>Nama</th>
                         <td>{{ $item->name }}</td>
                     </tr>
                     <tr>
                         <th>Lokasi</th>
                         <td>{{ $item->location }}</td>
                     </tr>
                     <tr>
                         <th>jumlah user</th>
                         <td>
                             <span class="badge bg-primary">
                               {{ $item->non_admin_users_count }} pengguna aplikasi
                             </span>
                         </td>
                     </tr>
                     <tr>
                         <th>Deskripsi</th>
                         <td>{{ $item->description ?? 'Tidak ada deskripsi' }}</td>
                     </tr>
                 </table>
                 <div class="pt-4">
                     <a href="{{ route('region.index') }}" class="btn btn-primary">Kembali</a>
                 </div>
             </div>
         </div>
    </div>
@endsection