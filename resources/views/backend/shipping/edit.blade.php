@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Shipping Cost</h5>
    <div class="card-body">
      <form method="post" action="{{route('shipping-update',$shipping->id)}}">
        @csrf 
        @method('POST')
        <div class="form-group">
          <label for="type" class="col-form-label">Region <span class="text-danger">*</span></label>
        <input id="type" type="text" name="type" placeholder="Enter Region"  value="{{$shipping->type}}" class="form-control">
        @error('type')
        <span class="text-danger">This field is required.</span>
        @enderror
        </div> 
        {{-- <div class="form-group">
          <label for="gratis_ongkir">Free Shipping</label><br>
          <input type="checkbox" name='gratis_ongkir' id='gratis_ongkir' value='{{$shipping->gratis_ongkir}}' {{(($shipping->gratis_ongkir) ? 'checked' : '')}}> Yes                        
        </div>     --}}
        <div class="form-group">
          <label for="status_biaya" class="col-form-label">Cost Status<span class="text-danger">*</span></label>
          <select name="status_biaya" class="form-control">
            <option value="1" {{(($shipping->status_biaya=='1') ? 'selected' : '')}}>Known</option>
            <option value="0" {{(($shipping->status_biaya=='0') ? 'selected' : '')}}>Uknown</option>
          </select>
          @error('status_biaya')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
      
        <div class="form-group">
          <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
        <input id="price" type="number" name="price" placeholder="Enter price"  value="{{$shipping->price}}" class="form-control">
        @error('price')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>    

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($shipping->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($shipping->status=='inactive') ? 'selected' : '')}}>Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush