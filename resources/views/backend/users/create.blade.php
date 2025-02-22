@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name</label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email"  value="{{old('email')}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputNohp" class="col-form-label">No Hp</label>
        <input id="inputHohp" type="text" name="no_hp" placeholder="Enter no hp ...62"  value="{{old('no_hp')}}" class="form-control">
        @error('no_hp')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{old('password')}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo</label>
        <div class="input-group">
           
            <input id="photos" class="form-control" type="file" name="photo" onchange="previewImages(event)">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control">
                <option value="">-----Select Role-----</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('scripts')

<script>
  function previewImages(event) {
      const holder = document.getElementById('holder');
      holder.innerHTML = ''; // Bersihkan pratinjau gambar sebelumnya

      const files = event.target.files; // Ambil semua file yang dipilih pengguna

      // Loop melalui setiap file
      for (let i = 0; i < files.length; i++) {
          const file = files[i];
          const reader = new FileReader();
          
          reader.onload = function (e) {
              const img = document.createElement('img');
              img.src = e.target.result;
              img.style.maxHeight = '100px'; // Atur tinggi maksimal pratinjau
              img.style.marginRight = '10px'; // Beri jarak antar gambar
              holder.appendChild(img); // Tambahkan gambar ke dalam kontainer
          }
          
          reader.readAsDataURL(file); // Konversi file menjadi URL yang bisa dibaca browser
      }
  }
</script>
@endpush