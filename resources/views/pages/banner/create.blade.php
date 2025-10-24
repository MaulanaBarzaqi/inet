@extends('layouts.default')

@section('content')
@section('title', 'Banner - Tambah Banner')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Tambah Banner</h5>
      <div class="card-body px-5">
        <form action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          {{-- nama --}}
          <div class="mb-3">
            <label class="form-label" for="title">title</label>
            <input 
                type="text" 
                id="title" 
                name="title"
                value="{{ old('title') }}"
                placeholder="judul banner" 
                class="form-control @error('title') is-invalid @enderror" />
            @error('title') <div class="form-text">{{ $message }}</div>@enderror
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
          <button type="submit" class="btn btn-primary">Tambah Banner</button>
        </form>
      </div>
    </div>
  </div>
@endsection