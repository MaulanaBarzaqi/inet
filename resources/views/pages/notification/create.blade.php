@extends('layouts.default')

@section('title', 'Notification - Kirim Notifikasi')

@section('content')
    <div class="col-md-12">
        <div class="card">
          <!-- Notifications -->
          <h5 class="card-header">Kirim Notifikasi</h5>
          <div class="card-body">
              <form action="" method="post">
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
                        class="form-control @error('title') is-invalid @enderror" />
                    @error('title') <div class="form-text">{{ $message }}</div>@enderror
                </div>
                {{-- notification --}}
                <div class="mb-3">
                    <label class="form-label" for="notification">isi notifikasi</label>
                    <textarea 
                        id="notification" 
                        name="notification"
                        rows="4"
                        placeholder="isi notifikasi"
                        class="form-control @error('notification') is-invalid @enderror">{{ old('notification') }}</textarea>
                    @error('notification') <div class="form-text">{{ $message }}</div>@enderror
                </div>
                {{-- target --}}
                <div class="col-md mb-3">
                    <label class="form-label d-block">Kirim ke :</label>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="targetAll"> Semua Pelanggan </label>
                        <input
                            id="targetAll"
                            name="target"
                            value="all"
                            class="form-check-input"
                            type="radio"
                            {{ old('target') == 'all' ? 'checked' : '' }}
                        />
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="targetUser"> Pelanggan Tertentu</label>
                        <input
                            id="targetUser"
                            name="target"
                            value="user"
                            class="form-check-input"
                            type="radio"
                            {{ old('target') == 'user' ? 'checked' : '' }}
                        />
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="targetRegion"> Daerah Tertentu</label>
                        <input
                            id="targetRegion"
                            name="target"
                            value="region"
                            class="form-check-input"
                            type="radio"
                            {{ old('target') == 'region' ? 'checked' : '' }}
                        />
                    </div>
                </div>
                {{-- region --}}
                <div class="mb-3">
                  <label for="selectRegion" class="form-label">Pilih Daerah</label>
                  <select class="form-select" id="selectRegion" name="region">">
                    <option selected disabled>Pilih Daerah</option>
                    <option value="1">PON 1</option>
                    <option value="2">PON 2</option>
                    <option value="3">PON 3</option>
                  </select>
                </div>
                {{-- user --}}
                <div class="mb-4">
                  <label for="selectUser" class="form-label">Untuk Pelanggan</label>
                  <input
                    class="form-control"
                    list="datalistOptions"
                    id="selectUser"
                    placeholder="Cari nama user..."
                  />
                  <datalist id="datalistOptions">
                    <option value="Maulana"></option>
                    <option value="Barzaqi"></option>
                    <option value="Hana"></option>
                    <option value="Shabriyah"></option>
                    <option value="samsul"></option>
                  </datalist>
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
    const radioAll = document.getElementById("targetAll");
    const radioUser = document.getElementById("targetUser");
    const radioRegion = document.getElementById("targetRegion");

    const userInput = document.getElementById("selectUser");
    const regionSelect = document.getElementById("selectRegion");

    function updateFields() {
      if (radioAll.checked) {
        userInput.disabled = true;
        regionSelect.disabled = true;
      } else if (radioUser.checked) {
        userInput.disabled = false;
        regionSelect.disabled = true;
      } else if (radioRegion.checked) {
        userInput.disabled = true;
        regionSelect.disabled = false;
      }
    }

    // Initial check
    updateFields();

    // Event listeners
    [radioAll, radioUser, radioRegion].forEach(radio => {
      radio.addEventListener('change', updateFields);
    });
  });
</script>
@endpush