@extends('layouts.default')

@section('content')
@section('title', 'Region - Ubah Region')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Ubah Region {{ $item->name }}</h5>
      <div class="card-body px-5">
        <form action="{{ route('region.update', $item->slug) }}" enctype="multipart/form-data" method="post">
            @method('put')
            @csrf
          {{-- nama --}}
          <div class="mb-3">
                <label class="form-label" for="name">nama</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name"
                    value="{{ old('name') ? old('name') : $item->name }}"
                    placeholder="nama region" 
                    class="form-control @error('name') is-invalid @enderror" />
                @error('name') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- location --}}
          <div class="mb-3">
                <label class="form-label" for="location">lokasi</label>
                <input 
                    type="text" 
                    id="location" 
                    name="location"
                    value="{{ old('location') ? old('location') : $item->location }}"
                    placeholder="lokasi region" 
                    class="form-control @error('location') is-invalid @enderror" />
                @error('location') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- deskripsi --}}
           <div class="mb-3">
                <label class="form-label" for="description">isi deskripsi</label>
                <textarea id="description" name="description" rows="4" placeholder="isi deskripsi" class="form-control @error('description') is-invalid @enderror">{{ old('description', $item->description) }}</textarea>
                    @error('description') <div class="form-text">{{ $message }}</div>@enderror
            </div>
          {{-- image --}}
          <div class="mb-3">
            <label for="" class="form-label">
              Image <span class="text-muted">(Ukuran: 1000x400px, maksimal 500KB)</span>
            </label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="" />
             <small class="text-muted">Format diperbolehkan: JPG, PNG</small>
            @error('image') <div class="form-text text-danger">{{ $message }}</div> @enderror

            @if ($item->image)
                <div class="mt-3">
                <p>Gambar saat ini:</p>
                <img width="150" src="{{ asset('storage/' . $item->image) }}" alt="preview">
              </div>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Ubah Region</button>
        </form>
      </div>
    </div>
  </div>
@endsection