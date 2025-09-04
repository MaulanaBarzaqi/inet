@extends('layouts.default')

@section('content')
@section('title', 'User - Detail User')
     <div class="card mb-4">
                    <h5 class="card-header">User Detail</h5>
                    
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $item->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $item->email }}</td>
                                </tr>
                                <tr>
                                    <th>Region</th>
                                    <td>
                                        @if($item->region)
                                            {{ $item->region->name }}
                                        @elseif($item->region_id)
                                            <span class="badge bg-danger">region telah dihapus (ID: {{ $item->region_id }})</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak ada region terkait</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <div class="region-section mt-2 p-3 bg-light rounded">
                                <h6 class="mb-3">Atur Region</h6>
                                @if (isset($regions) && $regions->count() > 0)
                                    <form action="{{ route('user.region', $item->uuid) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                                <div class="mb-4">
                                                    <label for="region_id" class="form-label">Pilih Region</label>
                                                    <select class="form-select" name="region_id" id="region_id">
                                                        <option value="">-- Pilih Region --</option>
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region->id }}" {{ $item->region_id == $region->id ? 'selected' : '' }}>
                                                                {{ $region->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('region_id')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-1"></i> Simpan Region
                                                    </button>
                                                </div>
                                            
                                    </form>
                                @else
                                     <div class="alert alert-warning">
                                        Tidak ada data region yang tersedia. Silakan tambahkan region terlebih dahulu.
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                  </div>
@endsection