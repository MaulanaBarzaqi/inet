@extends('layouts.default')

@section('title', 'Tambah Paket Internet')
@section('content')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Tambah Paket Internet</h5>
      <div class="card-body px-5">
        <form action="{{ route('internet-package.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          {{-- nama --}}
          <div class="mb-3">
            <label class="form-label" for="name">Nama</label>
            <input 
                type="text" 
                id="name" 
                name="name"
                value="{{ old('name') }}"
                placeholder="nama paket internet" 
                class="form-control @error('name') is-invalid @enderror" />
            @error('name') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- category --}}
          <div class="mb-3">
            <label class="form-label" for="category">Category</label>
            <input 
                type="text" 
                id="category"
                name="category"
                value="{{ old('category') }}"
                placeholder="nama category internet"
                class="form-control @error('category') is-invalid @enderror" />
            @error('category') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- speed --}}
          <div class="mb-3">
            <label class="form-label" for="speed">Speed</label>
            <input 
                type="text"
                id="speed" 
                name="speed"
                value="{{ old('speed') }}" 
                placeholder="kecepatan" 
                class="form-control @error('speed') is-invalid @enderror" />
            @error('speed') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- ideal device --}}
          <div class="mb-3">
            <label class="form-label" for="ideal-device">Ideal Device</label>
            <input 
                type="text"
                id="ideal-device" 
                name="ideal_device"
                value="{{ old('ideal_device') }}" 
                placeholder="ideal device" 
                class="form-control @error('ideal_device') is-invalid @enderror" />
            @error('ideal_device') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- installation --}}
          <div class="mb-3">
            <label class="form-label" for="installation">Installation</label>
            <input 
                type="number" 
                id="installation" 
                name="installation"
                value="{{ old('installation') }}"
                placeholder="biaya pemasangan" 
                class="form-control @error('installation') is-invalid @enderror" />
            @error('installation') <div class="text-muted">{{ $message }}</div> @enderror
          </div>
          {{-- monthly bill --}}
          <div class="mb-3">
            <label class="form-label" for="monthly-bill">Monthly Bill</label>
            <input 
                type="number" 
                id="monthly-bill"
                name="monthly_bill"
                value="{{ old('monthly_bill') }}" 
                placeholder="biaya bulanan" 
                class="form-control @error('monthly_bill') is-invalid @enderror" />
            @error('monthly_bill') <div class="text-mited">{{ $message }}</div> @enderror
          </div>
          {{-- image --}}
          <div class="mb-3">
            <label for="" class="form-label">
              Image <span class="text-muted">(Ukuran gambar: 512 x 512 piksel, maksimal 500KB)</span>
            </label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="" />
               <small class="text-muted">Format yang diperbolehkan: JPG, PNG. Disarankan resolusi tepat 512x512 px dan ukuran file tidak lebih dari 500KB.</small> 
            @error('image') <div class="form-text text-danger">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn btn-primary">Tambah Paket</button>
        </form>
      </div>
    </div>
  </div>
@endsection