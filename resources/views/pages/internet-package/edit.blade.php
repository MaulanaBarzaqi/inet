@extends('layouts.default')

@section('content')
@section('title', 'Paket Internet - Ubah Paket Internet')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Ubah Paket Internet {{ $item->name }}</h5>
      <div class="card-body px-5">
        <form action="{{ route('internet-package.update', $item->slug) }}" enctype="multipart/form-data" method="post">
            @method('put')
            @csrf
          {{-- nama --}}
          <div class="mb-3">
            <label class="form-label" for="name">Nama</label>
            <input 
                type="text" 
                id="name" 
                name="name"
                value="{{ old('name') ? old('name') : $item->name }}"
                placeholder="nama paket internet" 
                class="form-control @error('name') is-invalid @enderror" />
            @error('name') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- category --}}
          <div class="form-group mb-3">
                <label for="category_id">Kategori</label>
                
                @if(isset($categories) && $categories->count() > 0)
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                       @if($item->category_id && !$item->category)
                            <option value="{{ $item->category_id }}" selected style="color: red; font-style: italic;">
                                [DIHAPUS] Category ID: {{ $item->category_id }}
                            </option>
                        @endif
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                 {{-- Warning jika category saat ini sudah dihapus --}}
                {{-- Warning jika category saat ini sudah dihapus --}}
                @if($item->category_id && !$item->category)
                    <div class="alert alert-warning mt-2">
                        <i class="bx bx-alert"></i>
                        <strong>Peringatan:</strong> Category yang sebelumnya dipilih sudah dihapus. 
                        Silakan pilih category yang baru atau biarkan seperti ini untuk mempertahankan ID category.
                    </div>
                @endif
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tidak ada data kategori yang tersedia. Silakan tambahkan kategori terlebih dahulu.
                    </div>
                {{-- Tampilkan ID category yang sudah dihapus jika ada --}}
                 @if($item->category_id)
                      <input type="hidden" name="category_id" value="{{ $item->category_id }}">
                      <div class="alert alert-danger mt-2">
                          <i class="bx bx-error"></i>
                          <strong>Category ID {{ $item->category_id }} sudah dihapus.</strong>
                          ID category akan dipertahankan sebagai referensi.
                      </div>
                  @endif
                @endif
            </div>
          {{-- speed --}}
          <div class="mb-3">
            <label class="form-label" for="speed">Speed</label>
            <input 
                type="text"
                id="speed" 
                name="speed"
                value="{{ old('speed') ? old('speed') : $item->speed }}" 
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
                value="{{ old('ideal_device') ? old('ideal_device') : $item->ideal_device }}" 
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
                value="{{ old('installation') ? old('installation') : $item->installation }}"
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
                value="{{ old('monthly_bill') ? old('monthly_bill') : $item->monthly_bill }}" 
                placeholder="biaya bulanan" 
                class="form-control @error('monthly_bill') is-invalid @enderror" />
            @error('monthly_bill') <div class="text-mited">{{ $message }}</div> @enderror
          </div>
          {{-- image --}}
          <div class="mb-3">
            <label for="" class="form-label">
              Image <span class="text-muted">(Ukuran gambar: 512 x 512 piksel, maksimal 500KB)</span>
            </label>
            <input type="file" class="form-control  @error('image') is-invalid @enderror" name="image" id="" />
             <small class="text-muted">Format diperbolehkan: JPG, PNG</small>
             @error('image') <div class="form-text text-danger">{{ $message }}</div> @enderror

            @if ($item->image)
              <div class="mt-3">
                <p>Gambar saat ini:</p>
                <img width="150" src="{{ asset('storage/' . $item->image) }}" alt="preview">
              </div>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Ubah Paket</button>
        </form>
      </div>
    </div>
  </div>
@endsection