@extends('layouts.default')

@section('content')
@section('title', 'Region - Tambah Region')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Tambah Region</h5>
      <div class="card-body px-5">
        <form action="{{ route('region.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          {{-- nama --}}
          <div class="mb-3">
            <label class="form-label" for="name">nama</label>
            <input 
                type="text" 
                id="name" 
                name="name"
                value="{{ old('name') }}"
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
                value="{{ old('location') }}"
                placeholder="location region" 
                class="form-control @error('location') is-invalid @enderror" />
            @error('location') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- deskripsi --}}
           <div class="mb-3">
                <label class="form-label" for="description">isi deskripsi</label>
                <textarea id="description" name="description" rows="4" placeholder="isi deskripsi" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description') <div class="form-text">{{ $message }}</div>@enderror
            </div>
          {{-- image --}}
          <div class="mb-3">
            <label for="" class="form-label">
              Image <span class="text-muted">(Ukuran gambar: 1200 x 400 piksel, maksimal 500KB)</span>
            </label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="" />
            <small class="text-muted">Format yang diperbolehkan: JPG, PNG. Disarankan resolusi tepat 1200x400px dan ukuran file tidak lebih dari 500KB.</small>
            @error('image') <div class="form-text text-danger">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn btn-primary">Tambah Region</button>
        </form>
      </div>
    </div>
  </div>
@endsection