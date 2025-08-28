@extends('layouts.default')

@section('content')
@section('title', 'Banner - Ubah Banner')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Ubah Banner {{ $item->title }}</h5>
      <div class="card-body px-5">
        <form action="{{ route('banner.update', $item->id) }}" enctype="multipart/form-data" method="post">
            @method('put')
            @csrf
          {{-- nama --}}
          <div class="mb-3">
            <label class="form-label" for="title">judul</label>
            <input 
                type="text" 
                id="title" 
                name="title"
                value="{{ old('title') ? old('title') : $item->title }}"
                placeholder="nama judul banner" 
                class="form-control @error('title') is-invalid @enderror" />
            @error('title') <div class="form-text">{{ $message }}</div>@enderror
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
          <button type="submit" class="btn btn-primary">Ubah Banner</button>
        </form>
      </div>
    </div>
  </div>
@endsection