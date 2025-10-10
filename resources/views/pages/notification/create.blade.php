@extends('layouts.default')

@section('title', 'Notification - Kirim Notifikasi')

@section('content')
    <div class="col-md-12">
        <div class="card">
          <!-- Notifications -->
          <h5 class="card-header">Kirim Notifikasi</h5>
          <div class="card-body">

           {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

              <form action="{{ route('notifications.send') }}" method="post">
                @csrf
                {{-- title --}}
                <div class="mb-3">
                    <label class="form-label" for="title">Judul</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="judul notifikasi" 
                        class="form-control @error('title') is-invalid @enderror" 
                        required 
                    />
                    @error('title') <div class="form-text text-danger">{{ $message }}</div>@enderror
                </div>

                {{-- body --}}
                <div class="mb-3">
                    <label class="form-label" for="body">isi notifikasi</label>
                    <textarea 
                        id="body" 
                        name="body"
                        rows="4"
                        placeholder="isi notifikasi"
                        class="form-control @error('body') is-invalid @enderror" 
                        required>
                        {{ old('body') }}
                    </textarea>
                    @error('body') <div class="form-text text-danger">{{ $message }}</div>@enderror
                </div>
                
                {{-- target --}}
                <div class="col-md mb-3">
                    <label class="form-label d-block">Kirim ke :</label>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="targetAll"> Semua Pelanggan </label>
                        <input
                            id="targetAll"
                            name="target_type"
                            value="all"
                            class="form-check-input"
                            type="radio"
                            {{ old('target_type') == 'all' ? 'checked' : '' }}
                            required
                        />
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="targetUser"> Pelanggan Tertentu</label>
                        <input
                            id="targetUser"
                            name="target_type"
                            value="user"
                            class="form-check-input"
                            type="radio"
                            {{ old('target_type') == 'user' ? 'checked' : '' }}
                        />
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="targetRegion"> Daerah Tertentu</label>
                        <input
                            id="targetRegion"
                            name="target_type"
                            value="region"
                            class="form-check-input"
                            type="radio"
                            {{ old('target_type') == 'region' ? 'checked' : '' }}
                        />
                    </div>
                </div>

                {{-- region --}}
                <div class="mb-3" id="regionField" style="display: none;">
                  <label for="region_id" class="form-label">Pilih Daerah</label>
                  <select class="form-select" id="region_id" name="region_id">
                    <option value="">pilih daerah</option>
                    @foreach ($regions as $region)
                      <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                        {{ $region->name }} - {{ $region->location }}
                      </option>
                    @endforeach
                  </select>
                    @error('region_id') <div class="form-text text-danger">{{ $message }}</div>@enderror
                </div>

                {{-- user --}}
                <div class="mb-4" id="userField" style="display: none;">
                  <label for="user_id" class="form-label">Untuk Pelanggan</label>
                  <select class="form-select" name="user_id" id="user_id">
                    <option value="">Pilih pelanggan</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                      {{ $user->name }} - {{ $user->email }}
                    </option>
                    @endforeach
                  </select>
                    @error('user_id') <div class="form-text text-danger">{{ $message }}</div>@enderror
                </div>
                 <button type="submit" class="btn btn-primary">Kirim Notifikasi</button>
              </form>
          </div>
        </div>
    </div>
@endsection
@push('after-script')
    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const targetAll = document.getElementById("targetAll");
    const targetUser = document.getElementById("targetUser");
    const targetRegion = document.getElementById("targetRegion");
    const userField = document.getElementById("userField");
    const regionField = document.getElementById("regionField");

    function updateFields() {
     userField.style.display = targetUser.checked ? 'block' : 'none';
     regionField.style.display = targetRegion.checked ? 'block' : 'none';

      // Reset values when hidden
     if (!targetUser.checked) document.getElementById('user_id').value = '';
     if (!targetRegion.checked) document.getElementById('region_id').value = '';

    }

    // Initial check
    updateFields();

    // Event listeners
    [targetAll, targetUser, targetRegion].forEach(radio => {
      radio.addEventListener('change', updateFields);
    });
  });
</script>
@endpush