@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Order Update Refund</h5>
  <div class="card-body">
    <form action="{{route('refund.update',$refund->id)}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="totalrefund" class="col-form-label">Total Refund <span class="text-danger">*</span></label>
        <input id="totalrefund" type="number" name="total_refund" placeholder="Enter total refund"  value="{{old('total_refund')}}" class="form-control">
        @error('total_refund')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="date_transfer" class="col-form-label">Date Transfer <span class="text-danger">*</span></label>
        <input id="date_transfer" type="datetime-local" name="date_transfer" placeholder=""  value="{{now()->format('Y-m-d\TH:i')}}" class="form-control">
        @error('date_transfer')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="buktitransfer" class="col-form-label">Bukti Transfer <span class="text-danger">*</span></label>
        <div class="input-group">
            
        <input id="buktitransfer" class="form-control" type="file" name="bukti_transfer" onchange="previewImages(event)">
      </div>
      <div id="holder" style="margin-top:15px;max-height:100px;"></div>

        @error('bukti_transfer')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="status">Status :</label>
        <select name="status" id="" class="form-control">
          <option value="completed" >Completed</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
