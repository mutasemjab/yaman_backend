@extends('layouts.admin')
@section('title')
{{ __('messages.offers') }}
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> {{ __('messages.New') }}{{ __('messages.offers') }}   </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="{{ route('offers.store') }}" method="post" enctype='multipart/form-data'>
        <div class="row">
        @csrf


        <div class="col-md-6">
            <div class="form-group">
              <label>  {{ __('messages.Price') }}</label>
              <input name="price" id="price" class="form-control" value="{{ old('price') }}"    >
              @error('price')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>  {{ __('messages.start_at') }}</label>
              <input type="date" name="start_at" id="price" class="form-control" value="{{ old('start_at') }}"    >
              @error('start_at')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>  {{ __('messages.end_at') }}</label>
              <input type="date" name="expired_at" id="price" class="form-control" value="{{ old('expired_at') }}"    >
              @error('expired_at')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            </div>



            <div class="form-group col-md-6">
                <label for="product_id">{{ __('messages.products') }}</label>
                <select class="form-control" name="product" id="product_id">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name_ar }}</option>
                    @endforeach
                </select>
                @error('product')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>




      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> {{ __('messages.Submit') }}</button>
        <a href="{{ route('offers.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>

      </div>
    </div>

  </div>
            </form>



            </div>




        </div>
      </div>






@endsection


@section('script')

@endsection






