@extends('layouts.default')

@section('content')
@section('title', 'Categories - Tambah Category')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Tambah Category</h5>
      <div class="card-body px-5">
        <form action="{{ route('category.store') }}" method="post">
          @csrf
          {{-- nama --}}
          <div class="mb-3">
            <label class="form-label" for="name">nama Kategori</label>
            <input 
                type="text" 
                id="name" 
                name="name"
                value="{{ old('name') }}"
                placeholder="nama kategori" 
                class="form-control @error('name') is-invalid @enderror" />
            @error('name') <div class="form-text">{{ $message }}</div>@enderror
          </div>
          {{-- deskripsi --}}
           <div class="mb-3">
                <label class="form-label" for="description">isi deskripsi</label>
                <textarea id="description" name="description" rows="4" placeholder="isi deskripsi" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description') 
                      <div class="form-text">
                        {{ $message }}
                      </div>
                    @enderror
            </div>
          <button type="submit" class="btn btn-primary">Tambah Category</button>
        </form>
      </div>
    </div>
  </div>
@endsection