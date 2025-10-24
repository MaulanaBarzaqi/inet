@extends('layouts.default')

@section('content')
@section('title', 'Categories - Ubah Category')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Ubah Category {{ $item->name }}</h5>
      <div class="card-body px-5">
        <form action="{{ route('category.update', $item->slug) }}" enctype="multipart/form-data" method="post">
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
          {{-- deskripsi --}}
           <div class="mb-3">
                <label class="form-label" for="description">isi deskripsi</label>
                <textarea id="description" name="description" rows="4" placeholder="isi deskripsi" class="form-control @error('description') is-invalid @enderror">{{ old('description', $item->description) }}</textarea>
                    @error('description') <div class="form-text">{{ $message }}</div>@enderror
            </div>
          <button type="submit" class="btn btn-primary">Ubah Category</button>
        </form>
      </div>
    </div>
  </div>
@endsection